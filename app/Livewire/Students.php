<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\User;
use App\Models\AcademyUser;
use App\Models\State;
use App\Models\Role;
use App\Models\Academy;
use App\Enums\ErrorCodes;

class Students extends Component
{
    public $id;
    public $email;
    public $date_of_birth;
    public $fecha_registro;
    public $name;
    public $phone;
    public $password;
    public $password_confirmation;
    public $students;
    public $studentId;
    public $state_id;
    public $rol_id;
    public $states;
    public $roles;
    public $sessionUser;
    public $academies;

    public function mount()
    {
        $this->sessionUser = auth()->user()->id;
        $this->updateStudents();

        $this->states = State::all();
        $this->roles = Role::where('name', 'Estudiante')->get();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function delete($id)
    {
        try {
            User::where('id', $id)->delete();
            return $this->redirect('/std/r', navigate: true);
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::STUDENT_DELETE_ERROR), tipo: 'error', code: ErrorCodes::STUDENT_DELETE_ERROR);
        }
    }

    //funcion para cambiar el estado del usuario a inactivo
    public function disable($id)
    {
        try {
            DB::beginTransaction();
            $student = User::findOrFail($id);
            $student->update([
                'state_id' => 2
            ]);

            DB::commit();
            $this->updateStudents();
            $this->reset(['name', 'email', 'date_of_birth', 'phone', 'state_id', 'rol_id']);
            $this->dispatch('mostrarAlerta', mensaje: 'Usuario inactivado correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::STUDENT_ACTIVE_ERROR), tipo: 'error', code: ErrorCodes::STUDENT_ACTIVE_ERROR);
        }
    }

    public function edit($id)
    {
        $student = User::findOrFail($id);
        $student_rol = $student->roles->first();

        $this->studentId = $student->id;
        $this->email = $student->email;
        $this->date_of_birth = $student->date_of_birth;
        $this->name = $student->name;
        $this->phone = $student->phone;
        $this->state_id = $student->state_id;
        $this->rol_id = $student_rol->name;
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $student = User::findOrFail($this->studentId);
            $student->update([
                'email' => $this->email,
                'date_of_birth' => $this->date_of_birth,
                'name' => $this->name,
                'phone' => $this->phone,
                'state_id' => $this->state_id,
            ]);

            $this->updateStudents();
            $this->reset(['name', 'email', 'date_of_birth', 'phone', 'state_id', 'rol_id', 'password', 'password_confirmation']);
            $this->dispatch('mostrarAlerta', mensaje: 'Usuario actualizado correctamente.', tipo: 'success');
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::STUDENT_UPDATE_ERROR), tipo: 'error', code: ErrorCodes::STUDENT_UPDATE_ERROR);
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();

            $user = User::create([
                'email' => $this->email,
                'date_of_birth' => $this->date_of_birth,
                'created_at' => now(),
                'password' => bcrypt($this->password),
                'password_confirmation' => bcrypt($this->password_confirmation),
                'state_id' => $this->state_id,
                'role_id' => $this->rol_id,
                'name' => $this->name,
                'phone' => $this->phone
            ]);

            $user->assignRole($this->rol_id);

            AcademyUser::create([
                'academy_id' => AcademyUser::where('user_id', $this->sessionUser)->first()->academy_id,
                'user_id' => $user->id,
            ]);

            $this->updateStudents();
            $this->reset(['name', 'email', 'date_of_birth', 'phone', 'state_id', 'rol_id', 'password', 'password_confirmation']);
            $this->dispatch('mostrarAlerta', mensaje: 'Usuario creado correctamente.', tipo: 'success');
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::STUDENT_CREATE_ERROR), tipo: 'error', code: ErrorCodes::STUDENT_CREATE_ERROR);
        }
    }

    public function render()
    {
        return view('livewire.students', [
            'teachers' => $this->students
        ]);
    }

    //funcion para actualizar el arreglo de estudiantes
    public function updateStudents()
    {
        if (User::find($this->sessionUser)->hasRole('Profesor')) {
        }
        if (User::find($this->sessionUser)->hasRole('SuperAdmin')) {
            $this->students = User::role('Estudiante')->whereHas('state', function ($query) {
                $query->where('id', '1'); // Filtra para el estado activo
            })
                ->with('academyUsers.academy', 'state')
                ->get();
            //taer las academias que se encuentran activas
            $this->academies = Academy::where('state_id', 1)->get();
        } else if (User::find($this->sessionUser)->hasRole('Administrador')) {
            $academyId = AcademyUser::where('user_id', $this->sessionUser)->first()->academy_id;

            $this->students = User::role('Estudiante')->whereHas('state', function ($query) {
                $query->where('id', '1'); // Filtra para el estado activo
            })
                ->whereHas('academyUsers.academy', function ($query) use ($academyId) {
                    $query->where('id', $academyId); // Filtra por el ID de la academia específica
                })
                ->with('academyUsers.academy', 'state')
                ->get();
        }
    }
}

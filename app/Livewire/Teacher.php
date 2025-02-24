<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\User;
use App\Models\AcademyUser;

class Teacher extends Component
{
    public $id;
    public $email;
    public $especialidad;
    public $fecha_contratacion;
    public $name;
    public $phone;
    public $teachers;
    public $teacherId;

    public $sessionUser;
    public $students;
    public $student_id;

    public function mount()
    {
        $this->sessionUser = auth()->user()->id;
        $this->updateTeachers();

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

    public function delete($id)
    {
        try {
            Profesores::where('id',$id)->delete();
            return $this->redirect('/tch/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $teacher = User::findOrFail($id);

        $this->teacherId = $teacher->id;
        $this->email = $teacher->email;
        $this->especialidad = $teacher->especialidad;
        $this->fecha_contratacion = $teacher->fecha_contratacion;
        $this->name = $teacher->name;
        $this->phone = $teacher->phone;
    }

    public function update()
    {
        try {
            $teacher = User::findOrFail($this->teacherId);
            $teacher->update([
                'email' => $this->email,
                'especialidad' => $this->especialidad,
                'fecha_contratacion' => $this->fecha_contratacion,
                'name' => $this->name,
                'phone' => $this->phone
            ]);

            return $this->redirect('/tch/r', navigate: true);
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function save()
    {
        try {
            Profesores::create([
                'email' => $this->email,
                'especialidad' => $this->especialidad,
                'fecha_contratacion' => $this->fecha_contratacion,
                'name' => $this->name,
                'phone' => $this->phone,
                'created_at' => now(),
                'updated_at' => null
            ]);
            return $this->redirect('/tch/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function updateTeachers()
    {
        if (User::find($this->sessionUser)->hasRole('Profesor')) {
        }
        if (User::find($this->sessionUser)->hasRole('SuperAdmin')) {

        } else if (User::find($this->sessionUser)->hasRole('Administrador')) {
            $academyId = AcademyUser::where('user_id', $this->sessionUser)->first()->academy_id;

            $this->teachers = User::role('Profesor')->whereHas('state', function ($query) {
                $query->where('id', '1'); // Filtra para el estado activo
            })
                ->whereHas('academyUsers.academy', function ($query) use ($academyId) {
                    $query->where('id', $academyId); // Filtra por el ID de la academia específica
                })
                ->with('academyUsers.academy', 'state')
                ->get();
        }
    }

    //Funcion para quitar usuario como profesor
    public function removeTeacher($id)
    {
        try {
            DB::beginTransaction();
            $teacher = User::findOrFail($id);
            $teacher->removeRole('Profesor');
            $this->updateTeachers();
            DB::commit();
        } catch (\Exception $th) {
            dd($th);
            DB::rollBack();
        }
    }

    //Funcion para agregar estudiante como profesor
    public function addTeacher()
    {
        try {
            DB::beginTransaction();
            $teacher = User::findOrFail($this->student_id); 
            $teacher->assignRole('Profesor');
            $this->updateTeachers();
            DB::commit();
        } catch (\Exception $th) {
            dd($th);
            DB::rollBack();
        }
    }

    public function render()
    {
        return view('livewire.teacher',[
            'teachers' => $this->teachers
        ]);
    }
}

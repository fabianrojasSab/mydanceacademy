<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\State;
use App\Actions\Fortify\CreateNewUser;
use App\Models\Academy;
use App\Models\AcademyUser;

class Usuarios extends Component
{
    public $users;
    public $roles;
    public $name;
    public $email;
    public $date_of_birth;
    public $phone;
    public $state_id;
    public $especialidad_id;
    public $password;
    public $password_confirmation;
    public $rol_id;
    public $usuarioId;
    public $states;
    public $academies;
    public $academyId;

    public function mount()
    {
        //traer la informacion del modelo y guardarla en la variable usuarios
        $this->users = User::with('state','roles')->get();
        $this->roles = Role::all();
        $this->states = State::all();
        $this->academies = Academy::all();
    }

    public function register()
    {
        return view('auth.register', ['roles' => Role::all(),]);
    }

    public function delete($id)
    {
        try {
            User::where('id',$id)->delete();
            return $this->redirect('/usr/r',navigate:true); 
        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $user_rol = $usuario->roles->first();
        $academy = AcademyUser::where('user_id', $usuario->id)->first();

        $this->usuarioId = $usuario->id;
        $this->name = $usuario->name;
        $this->email = $usuario->email;
        $this->rol_id = $usuario->rol_id;
        $this->phone = $usuario->phone;
        $this->date_of_birth = $usuario->date_of_birth;
        $this->state_id = $usuario->state_id;
        $this->rol_id = $user_rol->name;
        $this->academyId = $academy->academy_id;
    }

    public function update()
    {
        try {
            DB::beginTransaction();
            $usuario = User::findOrFail($this->usuarioId);
            $usuario->update([
                'name' => $this->name,
                'email' => $this->email,
                'rol_id' => $this->rol_id,
                'password' => bcrypt($this->password),
                'phone' => $this->phone,
                'date_of_birth' => $this->date_of_birth,
                'state_id' => $this->state_id
            ]);

            //buscar en el modelo AcademyUser la relacion del usuario con la academia y actualizarla
            $academyUser = AcademyUser::where('user_id', $this->usuarioId)->first();
            $academyUser->update([
                'academy_id'=> $this->academyId
            ]);

            DB::commit();
            $this->updateUsers();
            $this->reset(['name','email','date_of_birth','phone','state_id','rol_id','academyId','password','password_confirmation']);
            session()->flash('message', 'Usuario actualizado correctamente.');
        } catch (\Exception $th) {
            dd($th);
            DB::rollBack();
        }
    }

    public function save()
    {
        try {
            DB::beginTransaction();
            $sessionUser = auth()->user()->id;

            $user = User::create([
                'name' => $this->name,
                'email' => $this->email,
                'date_of_birth' => $this->date_of_birth,
                'phone' => $this->phone,
                'state_id' => $this->state_id,
                'password' => $this->password,
                'password_confirmation' => $this->password_confirmation
            ]);

            $user->assignRole($this->rol_id);

            //valida si el usuario de la  sesion es rol SuperAdmin y crear la relacion del usuario con la academia
            if (User::find($sessionUser)->hasRole('SuperAdmin')){
                //valida si el rol del usuario a registrar es profesor, no se le asigna una academia
                if ($this->rol_id != 'Profesor'){
                    $creator = new AcademyUser();
                    $creator->create([
                        'academy_id' => $this->academyId,
                        'user_id' => $user->id
                    ]);
                }
            }

            DB::commit();
            $this->updateUsers();
            $this->reset('name','email','date_of_birth','phone','state_id','password','password_confirmation','rol_id');
            session()->flash('message', 'Usuario creado correctamente.');

        } catch (\Exception $th) {
            dd($th);
            DB::rollBack();
        }
    }

    public function render()
    {
        //retornar la vista con los usuarios y roles
        return view('livewire.usuarios');
    }

    //Funcion para actualizar el arreglo de usuarios
    public function updateUsers()
    {
        $this->users = User::with('state','roles')->get();
    }
}

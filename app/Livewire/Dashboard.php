<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\State;
use App\Models\Academy;

class Dashboard extends Component
{
    public $view = '';

    public $roles;
    public $permissions;
    public $users;
    public $states;

    public $userId;
    public $name;
    public $email;
    public $password;
    public $rol_id;
    public $estado_id;

    public $totalUsers;
    public $totalRoles;
    public $totalPermissions;
    public $totalStates;
    public $totalAcademies;

    public function mount()
    {
        $this->users = User::with('state','roles')->get();
        $this->roles = Role::all();
        $this->permissions = Permission::all();
        $this->states = State::all();
        
        $this->totalUsers = User::count();
        $this->totalRoles = Role::count();
        $this->totalPermissions = Permission::count();
        $this->totalStates = State::count();
        $this->totalAcademies = Academy::count();
    }

    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function changeView($view)
    {
        $this->view = $view;
    }

    public function render()
    {
        return view('livewire.dashboard');
    }

    public function saveUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'rol_id' => 'required',
            'estado_id' => 'required',
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
            'rol_id' => $this->rol_id,
            'estado_id' => $this->estado_id,
        ]);

        $user->assignRole($this->rol_id);

        $this->reset(['name', 'email', 'password', 'rol_id', 'estado_id']);
    }
}

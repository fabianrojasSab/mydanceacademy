<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Enums\ErrorCodes;

class Roles extends Component
{
    public $id;
    public $name;
    public $guard_name;
    public $created_at;
    public $updated_at;
    public $roles;
    public $rolId;

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function delete($id)
    {
        try {
            Role::where('id',$id)->delete();
            return $this->roles = Role::all();
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::ROLE_DELETE_ERROR), tipo: 'error', code: ErrorCodes::ROLE_DELETE_ERROR);
        }
    }

    public function edit($id)
    {
        $rol = Role::findOrFail($id);

        $this->rolId = $rol->id;
        $this->name = $rol->name;
        $this->guard_name = $rol->guard_name;
    }

    public function update()
    {
        try {
            Role::where('id', $this->rolId)->update([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
                'updated_at' => now()
            ]);

            $this->roles = Role::all();
            $this->reset(['name', 'guard_name']);
            $this->dispatch('mostrarAlerta', mensaje: 'Rol actualizado correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::ROLE_UPDATE_ERROR), tipo: 'error', code: ErrorCodes::ROLE_UPDATE_ERROR);
            $this->reset(['name','description','date','amount','student_id','lesson_id']);
        }
    }

    public function save()
    {
        try {
            // Crear una instancia de CreateNewUser
            $creator = new Role();

        
            $creator->create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
                'created_at' => now(),
                'updated_at' => null
            ]);

            $this->roles = Role::all();
            $this->reset(['name', 'guard_name']);
            $this->dispatch('mostrarAlerta', mensaje: 'Rol creado correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::ROLE_CREATE_ERROR), tipo: 'error', code: ErrorCodes::ROLE_CREATE_ERROR);
            $this->reset(['name','description','date','amount','student_id','lesson_id']);
        }
    }

    public function render()
    {
        return view('livewire.roles');
    }
}

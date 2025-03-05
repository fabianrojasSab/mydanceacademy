<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use App\Enums\ErrorCodes;

class Permissions extends Component
{
    public $id;
    public $name;
    public $guard_name;
    public $created_at;
    public $updated_at;
    public $permissions;
    public $permissionId;

    public function mount()
    {
        $this->permissions = Permission::all();
    }

    public function delete($id)
    {
        try {
            Permission::where('id',$id)->delete();
            return $this->permissions = Permission::all();
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::PERMISSION_DELETE_ERROR), tipo: 'error', code: ErrorCodes::PERMISSION_DELETE_ERROR);
        }
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        $this->permissionId = $permission->id;
        $this->name = $permission->name;
        $this->guard_name = $permission->guard_name;
    }

    public function update()
    {
        try {
            Permission::where('id', $this->permissionId)->update([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
                'updated_at' => now()
            ]);

            $this->permissions = Permission::all();
            $this->reset(['name', 'guard_name']);
            $this->dispatch('mostrarAlerta', mensaje: 'Permiso actualizado correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::PERMISSION_UPDATE_ERROR), tipo: 'error', code: ErrorCodes::PERMISSION_UPDATE_ERROR);
            $this->reset(['name','description','date','amount','student_id','lesson_id']);
        }
    }

    public function save()
    {
        try {
            Permission::create([
                'name' => $this->name,
                'guard_name' => $this->guard_name,
                'created_at' => now(),
                'updated_at' => null
            ]);

            $this->permissions = Permission::all();
            $this->reset(['name', 'guard_name']);
            $this->dispatch('mostrarAlerta', mensaje: 'Permiso creado correctamente.', tipo: 'success');
        } catch (\Exception $th) {
            $this->dispatch('mostrarAlerta', mensaje: __('errors.' . ErrorCodes::PERMISSION_CREATE_ERROR), tipo: 'error', code: ErrorCodes::PERMISSION_CREATE_ERROR);
            $this->reset(['name','description','date','amount','student_id','lesson_id']);
        }
    }

    public function render()
    {
        return view('livewire.permissions');
    }
}

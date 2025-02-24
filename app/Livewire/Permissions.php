<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

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
            dd($th);
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
            session()->flash('message', 'Permiso actualizado correctamente.');

        } catch (\Exception $th) {
            dd($th);
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
            session()->flash('message', 'Permiso creado correctamente.');

        } catch (\Exception $th) {
            dd($th);
        }
    }

    public function render()
    {
        return view('livewire.permissions');
    }
}

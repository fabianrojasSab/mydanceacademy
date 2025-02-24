<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamos los roles
        $superAdminrole = Role::firstOrCreate(['name' => 'SuperAdmin']); 
        $adminrole = Role::firstOrCreate(['name' => 'Administrador']);
        $teacherrole = Role::firstOrCreate(['name' => 'Profesor']);
        $studentrole = Role::firstOrCreate(['name' => 'Estudiante']);

        // Creamos los permisos
        Permission::firstOrCreate(['name' => 'create-clases']);
        Permission::firstOrCreate(['name' => 'edit-clases']);
        Permission::firstOrCreate(['name' => 'delete-clases']);
        Permission::firstOrCreate(['name' => 'create-users']);
        Permission::firstOrCreate(['name' => 'edit-users']);
        Permission::firstOrCreate(['name' => 'delete-users']);
        Permission::firstOrCreate(['name' => 'create-inscriptions']);
        Permission::firstOrCreate(['name' => 'edit-inscriptions']);
        Permission::firstOrCreate(['name' => 'delete-inscriptions']);
        Permission::firstOrCreate(['name' => 'create-payments']);
        Permission::firstOrCreate(['name' => 'edit-payments']);
        Permission::firstOrCreate(['name' => 'delete-payments']);

        //Asignamos los permisos a los roles
        $superAdminrole->givePermissionTo('create-clases');
        $superAdminrole->givePermissionTo('edit-clases');
        $superAdminrole->givePermissionTo('delete-clases');
        $superAdminrole->givePermissionTo('create-users');
        $superAdminrole->givePermissionTo('edit-users');
        $superAdminrole->givePermissionTo('delete-users');
        $superAdminrole->givePermissionTo('create-inscriptions');
        $superAdminrole->givePermissionTo('edit-inscriptions');
        $superAdminrole->givePermissionTo('delete-inscriptions');
        $superAdminrole->givePermissionTo('create-payments');
        $superAdminrole->givePermissionTo('edit-payments');
        $superAdminrole->givePermissionTo('delete-payments');

        $adminrole->givePermissionTo('create-clases');
        $adminrole->givePermissionTo('edit-clases');
        $adminrole->givePermissionTo('delete-clases');
        $adminrole->givePermissionTo('create-users');
        $adminrole->givePermissionTo('edit-users');
        $adminrole->givePermissionTo('delete-users');
        $adminrole->givePermissionTo('create-inscriptions');
        $adminrole->givePermissionTo('edit-inscriptions');
        $adminrole->givePermissionTo('delete-inscriptions');
        $adminrole->givePermissionTo('create-payments');
        $adminrole->givePermissionTo('edit-payments');
        $adminrole->givePermissionTo('delete-payments');

        $teacherrole->givePermissionTo('create-clases');
        $teacherrole->givePermissionTo('edit-clases');
        $teacherrole->givePermissionTo('delete-clases');
        $teacherrole->givePermissionTo('create-inscriptions');
        $teacherrole->givePermissionTo('edit-inscriptions');
        $teacherrole->givePermissionTo('delete-inscriptions');
        $teacherrole->givePermissionTo('create-payments');
        $teacherrole->givePermissionTo('edit-payments');
        $teacherrole->givePermissionTo('delete-payments');

        $studentrole->givePermissionTo('create-inscriptions');
        $studentrole->givePermissionTo('edit-inscriptions');
        $studentrole->givePermissionTo('delete-inscriptions');
        $studentrole->givePermissionTo('create-payments');
        $studentrole->givePermissionTo('edit-payments');
        $studentrole->givePermissionTo('delete-payments');
    }
}

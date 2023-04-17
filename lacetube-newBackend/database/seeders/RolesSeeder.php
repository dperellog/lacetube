<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Defining basic roles:
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleTeacher = Role::create(['name' => 'teacher']);
        $roleStudent = Role::create(['name' => 'student']);

        //Defining basic permissions:
        $perms = [];

        $perms['create_user'] = Permission::create(['name'=>'create_user']);
        $perms['modify_user'] = Permission::create(['name'=>'modify_user']);
        $perms['delete_user'] = Permission::create(['name'=>'delete_user']);
        $perms['modify_own_user'] = Permission::create(['name'=>'modify_own_user']);

        $perms['create_course'] = Permission::create(['name'=>'create_course']);
        $perms['modify_course'] = Permission::create(['name'=>'modify_course']);

        $perms['create_activity'] = Permission::create(['name'=>'create_activity']);
        $perms['modify_activity'] = Permission::create(['name'=>'modify_activity']);

        //Assigning Roles:
        // Admin Role:
        $roleAdmin->givePermissionTo($perms);

        // Teacher Role:
        $roleTeacher->givePermissionTo([
            $perms['create_course'],
            $perms['modify_course'],
            $perms['create_activity'],
            $perms['modify_activity']
        ]);


    }
}

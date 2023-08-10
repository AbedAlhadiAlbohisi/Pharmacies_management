<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        //صلاحيات الادمن
        // Permission::create(['name' => 'Create-', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Read-', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Update-', 'guard_name' => 'admin']);
        // Permission::create(['name' => 'Delete-', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Roles', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Role', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Role', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Permission', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Permissions', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Permission', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Permission', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Admins', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Admin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Admin', 'guard_name' => 'admin']);


        Permission::create(['name' => 'Create-City', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Cities', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-City', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-City', 'guard_name' => 'admin']);


        Permission::create(['name' => 'Read-Pharmaceuticals', 'guard_name' => 'admin']);



        Permission::create(['name' => 'Create-Pharmacist', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Pharmacists', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Pharmacist', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Pharmacist', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Delivery', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Deliveries', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Delivery', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Delivery', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Users', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-User', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-User', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Create-Order', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-Orders', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Update-Order', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Delete-Order', 'guard_name' => 'admin']);

        Permission::create(['name' => 'Read-AllAdmin', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-AllUser', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-AllPharmacist', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-AllPharmaceutical', 'guard_name' => 'admin']);
        Permission::create(['name' => 'Read-AllCities', 'guard_name' => 'admin']);


        // صلاحيات الصيدلاني
        Permission::create(['name' => 'Create-Pharmaceutical', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Read-Pharmaceuticals', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Update-Pharmaceutical', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Delete-Pharmaceutical', 'guard_name' => 'pharmacist']);


        Permission::create(['name' => 'Create-Order', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Read-Orders', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Update-Order', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Delete-Order', 'guard_name' => 'pharmacist']);


        Permission::create(['name' => 'Read-AllAdmin', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Read-AllUser', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Read-AllPharmacist', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Read-AllPharmaceutical', 'guard_name' => 'pharmacist']);
        Permission::create(['name' => 'Read-AllCities', 'guard_name' => 'pharmacist']);


        // صلاحيات المستخدم
        Permission::create(['name' => 'Create-Order', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Orders', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Order', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Order', 'guard_name' => 'user']);


        Permission::create(['name' => 'Read-AllAdmin', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-AllUser', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-AllPharmacist', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-AllPharmaceutical', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-AllCities', 'guard_name' => 'user']);


        Permission::create(['name' => 'Read-Pharmaceuticals', 'guard_name' => 'user']);
    }
}

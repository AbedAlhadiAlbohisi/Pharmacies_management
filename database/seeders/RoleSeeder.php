<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $allAdminPer = Permission::where('guard_name', 'admin')->get();
        Role::create(['guard_name' => 'admin', 'name' => 'SuperAdmin'])->givePermissionTo($allAdminPer);
    }
}

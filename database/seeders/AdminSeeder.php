<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'Abood',
            'email' => 'Abood@app.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => '0597814103',
        ])->syncRoles(['SuperAdmin']);
    }

    public function givPermission()
    {
        $admin = Admin::find(1);
        $Permissions = Permission::all();
        $allPermission = [];
        foreach ($Permissions as $Permission) {
            array_push($allPermission, $Permission->name);
        }
        $admin->givePermissionTo($allPermission);
    }
}

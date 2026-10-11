<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['superadmin', 'owner', 'pimpinan', 'admin-cabang', 'sales', 'service-advisor', 'mekanik', 'customer'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']);
        }

        User::where('email', 'admin@ayotonippon.local')->update(['email' => 'admin@ayotonippon.com']);

        $admin = User::firstOrCreate(
            ['email' => 'admin@ayotonippon.com'],
            ['name' => 'Superadmin', 'password' => 'password']
        );
        $admin->syncRoles(['superadmin']);
    }
}

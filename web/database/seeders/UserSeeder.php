<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $jkt = Branch::where('kode', 'JKT-01')->first() ?? Branch::first();
        $bdg = Branch::where('kode', 'BDG-01')->first() ?? Branch::skip(1)->first() ?? $jkt;

        $users = [
            // Super Admin
            ['name' => 'Super Admin', 'email' => 'admin@ayotonippon.com', 'role' => 'superadmin', 'branch_id' => null],

            // Sales
            ['name' => 'Raihan', 'email' => 'raihan@ayotonippon.com', 'role' => 'sales', 'branch_id' => $jkt?->id],
            ['name' => 'Dinar', 'email' => 'dinar@ayotonippon.com', 'role' => 'sales', 'branch_id' => $jkt?->id],
            ['name' => 'Fauzan', 'email' => 'fauzan@ayotonippon.com', 'role' => 'sales', 'branch_id' => $bdg?->id],

            // Mekanik
            ['name' => 'Joko', 'email' => 'joko@ayotonippon.com', 'role' => 'mekanik', 'branch_id' => $jkt?->id],
            ['name' => 'Juki', 'email' => 'juki@ayotonippon.com', 'role' => 'mekanik', 'branch_id' => $bdg?->id],

            // Admin Cabang
            ['name' => 'Owprabo', 'email' => 'owprabo@ayotonippon.com', 'role' => 'admin-cabang', 'branch_id' => $jkt?->id],
            ['name' => 'Okwijo', 'email' => 'okwijo@ayotonippon.com', 'role' => 'admin-cabang', 'branch_id' => $bdg?->id],

            // Pimpinan
            ['name' => 'Yunnita Rohmalia', 'email' => 'yunnita@ayotonippon.com', 'role' => 'pimpinan', 'branch_id' => $jkt?->id],
            ['name' => 'Rian Pratama', 'email' => 'rian.pimpinan@ayotonippon.com', 'role' => 'pimpinan', 'branch_id' => $bdg?->id],

            // Service Advisor
            ['name' => 'Rusdi', 'email' => 'rusdi@ayotonippon.com', 'role' => 'service-advisor', 'branch_id' => $jkt?->id],
            ['name' => 'Gilang Ramadhan', 'email' => 'gilang.sa@ayotonippon.com', 'role' => 'service-advisor', 'branch_id' => $bdg?->id],
        ];

        User::whereIn('email', ['hendra.pimpinan@ayotonippon.com', 'doni.sa@ayotonippon.com'])->delete();

        foreach ($users as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => 'password',
                    'branch_id' => $data['branch_id'],
                ]
            );
            $user->syncRoles([$data['role']]);
        }
    }
}

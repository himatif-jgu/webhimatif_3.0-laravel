<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Division;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndAdminSeeder extends Seeder
{
    /**
     * Seed roles and default admin user.
     */
    public function run(): void
    {
        $roles = ['admin', 'non_member', 'member', 'bph', 'demisioner', 'alumni'];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        $divisions = [
            ['name' => 'Ketua & Wakil Himpunan', 'slug' => 'ketua-wakil', 'description' => 'Pengurus inti'],
            ['name' => 'Bendahara', 'slug' => 'bendahara'],
            ['name' => 'Sekretaris', 'slug' => 'sekretaris'],
            ['name' => 'Departemen RISTEK', 'slug' => 'ristek'],
            ['name' => 'Departemen DANUS', 'slug' => 'danus'],
            ['name' => 'Departemen PSDA', 'slug' => 'psda'],
            ['name' => 'Departemen Medinfo', 'slug' => 'medinfo'],
            ['name' => 'Departemen HUMAS', 'slug' => 'humas'],
        ];

        foreach ($divisions as $division) {
            Division::firstOrCreate(
                ['slug' => $division['slug']],
                ['name' => $division['name'], 'description' => $division['description'] ?? null]
            );
        }

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'student_number' => 'ADMIN' . now()->format('Ymd'),
                'batch_year' => (int) now()->year,
                'is_active' => true,
                'password' => 'admin19',
                'email_verified_at' => now(),
            ]
        );

        if (! $adminUser->hasRole('admin')) {
            $adminUser->assignRole('admin');
        }

        if ($firstUser = User::find(1)) {
            if (! $firstUser->hasRole('admin')) {
                $firstUser->assignRole('admin');
            }
        }
    }
}

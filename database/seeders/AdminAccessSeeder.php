<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TeamUnit;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminAccessSeeder extends Seeder
{
    public const ADMIN_EMAIL = 'himatif.19@jgu.ac.id';

    public const ADMIN_PASSWORD = 'AdminHimatif@2026';

    public function run(): void
    {
        $roles = [
            'admin',
            'ketua',
            'wakil_ketua',
            'sekretaris',
            'sekretaris_1',
            'sekretaris_2',
            'bendahara',
            'bendahara_1',
            'bendahara_2',
            'ketua_departemen',
            'wakil_ketua_departemen',
            'anggota_divisi',
            'dosen',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        $divisions = [
            ['name' => 'Humas', 'slug' => 'humas', 'subtitle' => 'Hubungan Masyarakat', 'icon' => 'users', 'sort_order' => 10],
            ['name' => 'PSDA', 'slug' => 'psda', 'subtitle' => 'Pengembangan Sumber Daya Anggota', 'icon' => 'award', 'sort_order' => 20],
            ['name' => 'Ristek', 'slug' => 'ristek', 'subtitle' => 'Riset dan Teknologi', 'icon' => 'code', 'sort_order' => 30],
            ['name' => 'Danus', 'slug' => 'danus', 'subtitle' => 'Dana dan Usaha', 'icon' => 'shopping-cart', 'sort_order' => 40],
            ['name' => 'Medinfo', 'slug' => 'medinfo', 'subtitle' => 'Media dan Informasi', 'icon' => 'message-square', 'sort_order' => 50],
        ];

        foreach ($divisions as $division) {
            TeamUnit::updateOrCreate(
                ['slug' => $division['slug']],
                [
                    ...$division,
                    'description' => '<p>Divisi ' . $division['name'] . ' HIMATIF.</p>',
                    'is_active' => true,
                ],
            );
        }

        $permissions = [
            'app.access',
            'cms.view',
            'cms.create',
            'cms.update',
            'cms.delete',
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
            'profile.update',
            'attendance.view',
            'attendance.create',
            'attendance.update',
            'attendance.delete',
            'attendance.scan',
            'attendance.export',
            'utilities.view',
            'utilities.create',
            'utilities.update',
            'utilities.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        Role::findByName('admin')->syncPermissions($permissions);

        $admin = User::updateOrCreate(
            ['email' => self::ADMIN_EMAIL],
            [
                'name' => 'Admin HIMATIF',
                'username' => 'admin_himatif',
                'is_active' => true,
                'password' => self::ADMIN_PASSWORD,
                'email_verified_at' => now(),
            ],
        );

        $admin->syncRoles(['admin']);
    }
}

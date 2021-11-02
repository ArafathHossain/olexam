<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = [
            'can-create',
            'can-edit',
            'can-read',
            'can-delete',
            'manage-exam',
            'manage-result',
            'manage-user',
            'manage-role',
            'manage-mcq',
            'manage-subject',
            'manage-class',
            'manage-package',
            'manage-live-exam',
            'manage-footer',
            'manage-page',
            'manage-coupon',
            'manage-setting',
            'manage-about-page',
            'manage-faq-page',
        ];

        // seed for permission create
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
        // seed for role create
        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}

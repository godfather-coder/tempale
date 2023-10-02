<?php

namespace Database\Seeders;

use App\Models\User;
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
        $permisions = [
            // User permissions
            ['name' => 'user index'],
            ['name' => 'user show'],
            ['name' => 'user store'],
            ['name' => 'user update'],
            ['name' => 'user destroy'],
            // Section permissions
            ['name' => 'section index'],
            ['name' => 'section show'],
            ['name' => 'section store'],
            ['name' => 'section update'],
            ['name' => 'section destroy'],
            // Post permission
            ['name' => 'post index'],
            ['name' => 'post show'],
            ['name' => 'post store'],
            ['name' => 'post update'],
            ['name' => 'post destroy'],
            // Banner permission
            ['name' => 'banner index'],
            ['name' => 'banner show'],
            ['name' => 'banner store'],
            ['name' => 'banner update'],
            ['name' => 'banner destroy'],
            // Subscriber permission
            ['name' => 'subscriber index'],
            ['name' => 'subscriber show'],
            ['name' => 'subscriber store'],
            ['name' => 'subscriber update'],
            ['name' => 'subscriber destroy'],
            //Contact message permission
            ['name' => 'message index'],
            ['name' => 'message show'],
            ['name' => 'message store'],
            ['name' => 'message update'],
            ['name' => 'message destroy'],
        ];
        $admin = Role::firstOrCreate(['name' => 'admin']);
        foreach ($permisions as $permission) {
            $per = Permission::firstOrCreate($permission);
            $admin->givePermissionTo($per);
        }
        $contentManager = Role::firstOrCreate(['name' => 'content manager']);
        $contentManager->syncPermissions([
            'section index',
            'section show',
            'section store',
            'section update',
            'section destroy',
            'post index',
            'post show',
            'post store',
            'post update',
            'post destroy',
        ]);

        $writer = Role::firstOrCreate(['name' => 'writer']);
        $writer->syncPermissions([
            'post index',
            'post show',
            'post store',
            'post update',
            'post destroy',
        ]);
        $user = User::find(1);
        $user->assignRole('admin');
    }
}

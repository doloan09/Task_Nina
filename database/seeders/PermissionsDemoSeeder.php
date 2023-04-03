<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit articles']);
        Permission::create(['name' => 'delete articles']);
        Permission::create(['name' => 'publish articles']);
        Permission::create(['name' => 'unpublish articles']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writer']);
        $role1->givePermissionTo('edit articles');
        $role1->givePermissionTo('delete articles');

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('publish articles');
        $role2->givePermissionTo('unpublish articles');

        $role3 = Role::create(['name' => 'Super-Admin']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = User::query()->create([
            'name' => 'Example User',
            'email' => 'test@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole($role1);

        $user = User::query()->create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole($role2);

        $user = User::query()->create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole($role3);
    }
}

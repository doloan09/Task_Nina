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
        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'subjects']);
        Permission::create(['name' => 'semesters']);
        Permission::create(['name' => 'notifications']);
        Permission::create(['name' => 'points']);
        Permission::create(['name' => 'classes']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'student']);

        $role2 = Role::create(['name' => 'admin']);
        $role2->givePermissionTo('users');
        $role2->givePermissionTo('subjects');
        $role2->givePermissionTo('semesters');
        $role2->givePermissionTo('notifications');
        $role2->givePermissionTo('points');
        $role2->givePermissionTo('classes');

        $role3 = Role::create(['name' => 'teacher']);
        $role3->givePermissionTo('users');
        $role3->givePermissionTo('points');
        $role3->givePermissionTo('classes');

        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = User::query()->create([
            'name'          => 'Student',
            'email'         => 'student@example.com',
            'password'      => Hash::make('12345678'),
            'code_user'     => '191204220',
            'date_of_birth' => '2001-09-14',
        ]);
        $user->assignRole($role1);

        $user = User::query()->create([
            'name'          => 'Admin',
            'email'         => 'admin@example.com',
            'password'      => Hash::make('12345678'),
            'code_user'     => '191204221',
            'date_of_birth' => '2001-09-15',
        ]);
        $user->assignRole($role2);

        $user = User::query()->create([
            'name'          => 'Teacher',
            'email'         => 'teacher@example.com',
            'password'      => Hash::make('12345678'),
            'code_user'     => '191204222',
            'date_of_birth' => '2001-09-16',
        ]);
        $user->assignRole($role3);
    }
}

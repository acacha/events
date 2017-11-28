<?php

use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('assignPermission')) {
    function assignPermission($role, $permission) {
        if (! $role->hasPermissionTo($permission)) {
            $role->givePermissionTo($permission);
        }
    }
}

if (!function_exists('initialize_events_permissions')) {
    function initialize_events_permissions()
    {
        Permission::firstOrCreate(['name' => 'list-events']);
        Permission::firstOrCreate(['name' => 'show-event']);
        Permission::firstOrCreate(['name' => 'store-event']);
        Permission::firstOrCreate(['name' => 'update-event']);
        Permission::firstOrCreate(['name' => 'destroy-event']);

        $role = Role::firstOrCreate(['name' => 'events-manager']);

        assignPermission($role,'show-event');
        assignPermission($role,'store-event');
        assignPermission($role,'update-event');
        assignPermission($role,'destroy-event');


        Permission::firstOrCreate(['name' => 'list-users']);
        Permission::firstOrCreate(['name' => 'show-user']);
        Permission::firstOrCreate(['name' => 'store-user']);
        Permission::firstOrCreate(['name' => 'update-user']);
        Permission::firstOrCreate(['name' => 'destroy-user']);

        $role = Role::firstOrCreate(['name' => 'users-manager']);

        assignPermission($role,'list-users');
        assignPermission($role,'show-user');
        assignPermission($role,'store-user');
        assignPermission($role,'update-user');
        assignPermission($role,'destroy-user');
    }
}

if (!function_exists('create_admin_user')) {
    function create_admin_user()
    {
        factory(User::class)->create([
            'name'     => env('EVENTS_USER_NAME', 'Sergi Tur Badenas'),
            'email'    => env('EVENTS_USER_EMAIL', 'sergiturbadenas@gmail.com'),
            'password' => bcrypt(env('EVENTS_USER_PASSWORD')),
        ]);
    }
}

if (!function_exists('first_user_as_events_manager')) {
    function first_user_as_events_manager()
    {
        User::all()->first()->assignRole('events-manager');
        User::all()->first()->assignRole('users-manager');
    }
}

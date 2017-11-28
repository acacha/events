<?php

use App\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

if (!function_exists('initialize_events_permissions')) {
    function initialize_events_permissions()
    {
        Permission::firstOrCreate(['name' => 'list-events']);
        Permission::firstOrCreate(['name' => 'show-event']);
        Permission::firstOrCreate(['name' => 'store-event']);
        Permission::firstOrCreate(['name' => 'update-event']);
        Permission::firstOrCreate(['name' => 'destroy-event']);

        $role = Role::firstOrCreate(['name' => 'events-manager']);

        $role->givePermissionTo('list-events');
        $role->givePermissionTo('show-event');
        $role->givePermissionTo('store-event');
        $role->givePermissionTo('update-event');
        $role->givePermissionTo('destroy-event');


        Permission::firstOrCreate(['name' => 'list-users']);
        Permission::firstOrCreate(['name' => 'show-user']);
        Permission::firstOrCreate(['name' => 'store-user']);
        Permission::firstOrCreate(['name' => 'update-user']);
        Permission::firstOrCreate(['name' => 'destroy-user']);

        $role = Role::firstOrCreate(['name' => 'users-manager']);

        $role->givePermissionTo('list-users');
        $role->givePermissionTo('show-user');
        $role->givePermissionTo('store-user');
        $role->givePermissionTo('update-user');
        $role->givePermissionTo('destroy-user');
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
    }
}

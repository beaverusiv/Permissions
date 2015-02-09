<?php namespace Bocapa\Permissions\Seeds;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Bocapa\Permissions\Models\Group;
use Bocapa\Permissions\Models\Permission;
use App\User;

class PermissionsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear out the tables
        DB::table('groups')->delete();
        DB::table('permissions')->delete();
        DB::table('group_user')->delete();

        // Create default groups
        Group::create(['name' => 'Default']);
        $registered_group = Group::create(['name' => 'Registered']);
        $admin_group = Group::create(['name' => 'Admin', 'home_route' => 'groups.adminBrowse']);

        // Create default admin user
        $admin_user = User::where('email', '=', 'nic@bocapa.com')->first();
        $admin_user->groups()->save($registered_group);
        $admin_user->groups()->save($admin_group);

        // Create permission to let admin edit permissions
        $admin_group_perms = [
            new Permission([
                'name' => 'Login Form',
                'route_name' => 'auth.loginForm',
                'permitted' => true
            ]),
            new Permission([
                'name' => 'Process Login',
                'route_name' => 'auth.login',
                'permitted' => true
            ]),
            new Permission([
                'name' => 'View all groups',
                'route_name' => 'groups.adminBrowse',
                'permitted' => true
            ]),
            new Permission([
                'name' => 'View a group',
                'route_name' => 'groups.adminEdit',
                'permitted' => true
            ]),
            new Permission([
                'name' => 'Save a group',
                'route_name' => 'groups.adminSave',
                'permitted' => true
            ]),
            new Permission([
                'name' => 'Delete a group',
                'route_name' => 'groups.adminDelete',
                'permitted' => true
            ])
        ];
        $admin_group->permissions()->saveMany($admin_group_perms);
    }

}
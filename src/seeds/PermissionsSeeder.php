<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Bocapa\Permissions\Models\Group;
use Bocapa\Permissions\Models\Permission;

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
        Group::create(array('name' => 'Default'));
        $registered_group = Group::create(array('name' => 'Registered'));
        $admin_group = new Group(array('name' => 'Admin'));

        // Create default admin user
        // TODO: from config?
        $admin_user = User::where('email', '=', 'nic@bocapa.com')->first();
        $admin_user->groups()->save($registered_group);
        $admin_user->groups()->save($admin_group);

        // Create permission to let admin view backend
        $admin_dashboard_perm = new Permission(array(
                'name' => 'Admins View Backend',
                'route_name' => 'dashboard',
                'permitted' => true
        ));
        $admin_group->permissions()->save($admin_dashboard_perm);
    }

}
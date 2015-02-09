<?php namespace Bocapa\Permissions;

use Bocapa\Permissions\Models\Group;
use Bocapa\Permissions\Models\Permission;

class Permissions {


    public static function cache()
    {
        $permissions = Group::with('permissions')->get();
        \Cache::forever('permissions', $permissions);
    }

    /**
     * Check permissions to see if current user is allowed to
     * request route.
     *
     * @param string $route_name
     * @return boolean
     */
    public static function allowed($route_name)
    {
        // Base case: Everyone should be able to see the homepage
        if('default.route' == $route_name) return true;

        $cached_permissions = \Cache::get('permissions');

        // Given a user and a route name, find the corresponding
        // Permission if it exists (default: deny)
        $groups = $cached_permissions->filter(function($group)
        {
            return $group->name == 'Default' || $group->users->contains(\Auth::id());
        });

        foreach($groups as $group) {
            $permissions = $group->permissions->filter(function($permission) use($route_name)
            {
                return $permission->route_name == $route_name;
            });

            foreach($permissions as $permission) {
                if($permission->permitted) return true;
            }
        }

        return false;
    }

    /**
     * Make sure a group has all current routes in its permissions.
     * We do not fire a permissions changed event because we haven't
     * changed any access rules, just added explicit denies for new
     * routes.
     *
     * @param Group $group
     * @return void
     */
    public static function generate(Group $group)
    {
        $routes = \Route::getRoutes();

        foreach($routes as $route) {
            $create = true;
            foreach($group->permissions()->get() as $permission) {
                // Already made, skip
                if($route->getName() == $permission->route_name) {
                    $create = false;
                    break;
                }
            }

            if($create) {
                // TODO: defaults should be in Permission migration
                $permission = Permission::create([
                    'name' => '',
                    'route_name' => $route->getName(),
                    'permitted' => false
                ]);

                $group->permissions()->save($permission);
            }
        }
    }

}
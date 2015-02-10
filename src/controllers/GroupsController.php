<?php namespace Bocapa\Permissions\Controllers;

use Illuminate\Routing\Controller;
use Bocapa\Permissions\Models\Group;

class GroupsController extends Controller {

    public function adminBrowse()
    {
        if(Request::wantsJson()) {
            return Group::all()->toJson();
        }

        return View::make('permissions::groups/admin_browse')
                ->with(['groups' => Group::all(), 'user' => Auth::user()]);
    }

    public function adminEdit($id)
    {
        if(0 == $id) {
            return View::make('permissions::groups/admin_edit');
        }

        $group = Group::findOrFail($id);

        Event::fire('permissions.generate', [$group]);

        return View::make('permissions::groups/admin_edit')
                ->with(compact('group'));
    }

    public function adminSave($id)
    {
        if(0 == $id) {
            $group = Group::create([]);
        } else {
            $group = Group::findOrFail($id);
        }
        // If name was edited
        if(Input::has('name')) {
            $group->fill(Input::all())->save();
            $id = $group->id;

        // Otherwise it was the permissions that were edited
        } else {
            foreach($group->permissions()->get() as $permission) {
                $permission->name = Input::get($permission->id.'_name', '');
                $permission->permitted = Input::get($permission->id.'_permitted', false);
                $permission->save();
            }

            Event::fire('permissions.changed');
        }

        return Redirect::route('groups.adminEdit', ['id' => $id]);
    }

    public function adminDelete($id)
    {
        Group::destroy($id);

        return Redirect::route('groups.adminBrowse');
    }
}
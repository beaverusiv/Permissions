<?php

use Illuminate\Routing\Controller;
use Bocapa\Permissions\Models\Group;

class GroupsController extends Controller {

    public function adminBrowse()
    {
        return View::make('permissions::groups/admin_browse')
                ->with(['groups' => Group::all()]);
    }

    public function adminEdit($id)
    {
        $group = Group::findOrFail($id);
        Event::fire('permissions.generate', [$group]);

        return View::make('permissions::groups/admin_edit')
                ->with(compact('group'));
    }

    public function adminSave($id)
    {
        $group = Group::findOrFail($id);
        // If name was edited
        if(Input::has('name')) {
            $group->fill(Input::all())->save();

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
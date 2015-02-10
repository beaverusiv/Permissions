<?php

Route::any('admin/groups/browse', ['as' => 'groups.adminBrowse', 'uses' => 'Bocapa\Permissions\Controllers\GroupsController@adminBrowse']);
Route::get('admin/groups/edit/{id}', ['as' => 'groups.adminEdit', 'uses' => 'Bocapa\Permissions\Controllers\GroupsController@adminEdit'])->where('id', '[0-9]+');
Route::post('admin/groups/edit/{id}', ['as' => 'groups.adminSave', 'uses' => 'Bocapa\Permissions\Controllers\GroupsController@adminSave'])->where('id', '[0-9]+');
Route::get('admin/groups/delete/{id}', ['as' => 'groups.adminDelete', 'uses' => 'Bocapa\Permissions\Controllers\GroupsController@adminDelete'])->where('id', '[0-9]+');

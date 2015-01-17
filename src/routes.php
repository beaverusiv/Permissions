<?php

Route::get('admin/groups/browse', ['as' => 'groups.adminBrowse', 'uses' => 'GroupsController@adminBrowse']);
Route::get('admin/groups/edit/{id}', ['as' => 'groups.adminEdit', 'uses' => 'GroupsController@adminEdit'])->where('id', '[0-9]+');
Route::post('admin/groups/edit/{id}', ['as' => 'groups.adminSave', 'uses' => 'GroupsController@adminSave'])->where('id', '[0-9]+');
Route::post('admin/groups/delete/{id}', ['as' => 'groups.adminDelete', 'uses' => 'GroupsController@adminDelete'])->where('id', '[0-9]+');
Route::get('admin/groups/{id}', ['as' => 'groups.adminView', 'uses' => 'GroupsController@adminView'])->where('id', '[0-9]+');

<?php

Route::get('/', 'DashboardController@index')->name('dashboard.index');

Route::resource('users', 'UsersController')->parameters(['users' => 'id']);
Route::get('/users/{id}/status/{status}', 'UsersController@status')->name('users.status');

Route::get('/users/{id}/company/{company}', 'UsersController@companyAccess')->name('company.access');

Route::resource('assistants', 'AssistantsController')->parameters(['assistants' => 'id']);
Route::get('/assistants/{id}/status/{status}', 'AssistantsController@status')->name('assistants.status');

Route::resource('languages', 'LanguagesController')->parameters(['languages' => 'id']);
Route::get('/languages/{id}/status/{status}', 'LanguagesController@status')->name('languages.status');

Route::get('/settings/edit', 'SettingsController@editSettings')->name('settings.edit');
Route::put('/settings/update', 'SettingsController@updateSettings')->name('settings.update');
Route::get('/settings/email/test', 'SettingsController@emailTest')->name('settings.email.test');

Route::resource('pages', 'PagesController')->parameters(['pages' => 'id']);
Route::get('/pages/{id}/status/{status}', 'PagesController@status')->name('pages.status');
Route::put('/pages/{id}/update-instance', 'PagesController@instanceUpdate')->name('pages.update.instance');

Route::resource('posts', 'PostsController')->parameters(['posts' => 'id']);
Route::get('/posts/{id}/status/{status}', 'PostsController@status')->name('posts.status');
Route::put('/posts/{id}/update-instance', 'PostsController@instanceUpdate')->name('posts.update.instance');

Route::resource('blocks', 'BlocksController')->parameters(['blocks' => 'id']);
Route::get('/blocks/{id}/status/{status}', 'BlocksController@status')->name('blocks.status');
Route::put('/blocks/{id}/update-instance', 'BlocksController@instanceUpdate')->name('blocks.update.instance');

Route::resource('roles', 'RolesController')->parameters(['roles' => 'id']);
Route::resource('permissions', 'PermissionsController')->parameters(['permissions' => 'id']);
Route::get('/permissions/{role}/status/{permission}', 'PermissionsController@status')->name('permissions.status');

Route::resource('requests', 'RequestsController')->parameters(['requests' => 'id']);
Route::get('/requests/{id}/status/{status}', 'RequestsController@status')->name('requests.status');
Route::get('/requests/{id}/download', 'RequestsController@download')->name('requests.download');

Route::resource('company', 'CompanyController')->parameters(['company' => 'id']);
Route::get('/company/{id}/status/{status}', 'CompanyController@status')->name('company.status');
Route::get('/company/{id}/download', 'CompanyController@download')->name('company.download');
Route::get('/company/upload/{id}/rut', 'CompanyController@uploadRut')->name('company.upload.rut');
Route::post('/company/update/{id}/rut', 'CompanyController@updateRut')->name('company.update.rut'); 
Route::get('/company/{id}/remove/{user}/permissions', 'CompanyController@removePermissions')->name('company.remove.permissions'); 
Route::get('/company/search/from/rut', 'CompanyController@searchFromRut')->name('company.search.from.rut');
Route::post('/company/update-from-rut/', 'CompanyController@updateFromRut')->name('company.update.from.rut');

Route::resource('templates', 'TemplatesController')->parameters(['templates' => 'id']);

Route::get('/templates/{id}/status/{status}', 'TemplatesController@status')->name('templates.status');

Route::get('/RequestCompany', 'TemplatesController@RequestCompany')->name('RequestCompany.index');
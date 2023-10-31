<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', 'DashboardController@index')->name('account.dashboard');

// ------------------ Account --------------------
Route::get('/switch/company', 'DashboardController@switchCompany')->name('switch.company');
Route::get('/my-account', 'AccountController@myAccount')->name('account.myAccount');
Route::post('/update-my-account', 'AccountController@UpdateMyAccount')->name('account.updateMyAccount');

Route::resource('assistants', 'AssistantsController')->parameters(['assistants' => 'id']);
Route::get('/assistants/{id}/status/{status}', 'AssistantsController@status')->name('assistants.status');

Route::get('/company/show', 'CompanyController@show')->name('company.show');
Route::get('/company/download', 'CompanyController@download')->name('company.download');
Route::post('/company/updateLogo', 'CompanyController@updateLogo')->name('company.updateLogo');
Route::post('/company/update/{id}/rut', 'CompanyController@updateRut')->name('company.update.rut');

Route::post('/request/access', 'RequestController@access')->name('request.access');

Route::resource('templates', 'TemplatesController')->parameters(['templates' => 'id']);

Route::get('/templates/{id}/status/{status}', 'TemplatesController@status')->name('templates.status');
Route::get('/templates/export/excel', 'TemplatesController@export')->name('templates.export');

//Ruta para obtener los datos de plantillas y mostrar en Datatable
Route::middleware(['web','auth'])->post('templates-json','TemplatesController@templates')->name('templates-json');
Route::middleware(['web','auth'])->post('templates/delete','TemplatesController@delete')->name('templates.delete');

Route::get('/emissions', 'EmissionsController@index')->name('emissions.index');
Route::get('/emissions/my-certificates', 'EmissionsController@myCertificates')->name('emissions.my.certificates');
Route::get('/emissions/my-certificates/export/{id}', 'EmissionsController@myCertificatesExport')->name('emissions.my.certificates.export');
Route::get('/emissions/my-certificates/export-all', 'EmissionsController@myCertificatesExportAll')->name('emissions.my.certificates.export.all');

Route::get('/emissions/combo', 'EmissionsController@combo')->name('emissions.combo');
Route::get('/emissions/combo/period/type', 'EmissionsController@comboPeriodType')->name('emissions.combo.period_type');

Route::get('/emissions/generate', 'EmissionsController@generate')->name('emissions.generate');
Route::get('/emissions/processed', 'EmissionsController@processed')->name('emissions.processed');
Route::get('/emissions/declaration/{id}', 'EmissionsController@declaration')->name('emissions.declaration');
Route::get('/emissions/send/{id}', 'EmissionsController@sendAlert')->name('emissions.send.alert');
Route::post('/emissions/send/all', 'EmissionsController@sendAlertAll')->name('emissions.send.alert.all');


Route::post('/declarations/destroy', 'Delete_rows_controller@destroy')->name('declarations.destroy');

Route::get('/declarations', 'DeclarationsController@index')->name('declarations.index');
Route::post('/declarations/store', 'DeclarationsController@store')->name('declarations.store');


Route::get('/tickets/my', 'TicketsController@my')->name('tickets.my');
Route::post('/tickets/sendtikect', 'TicketsController@sendtikect')->name('tickets.sendtikect');

Route::get('/tickets/emission/{id}', 'TicketsController@emission')->name('tickets.emission');
Route::get('/tickets/emission/close/{id}', 'TicketsController@close')->name('tickets.close');

Route::post('/tickets/store/{id}', 'TicketsController@store')->name('tickets.emission.store');
Route::post('/tickets/store/{id}/reply', 'TicketsController@replyStore')->name('tickets.reply.store');

Route::get('/tickets/company', 'TicketsController@company')->name('tickets.company');
Route::get('/tickets/download/{id}', 'TicketsController@downloadFile')->name('tickets.download.file');
Route::get('/tickets/download/message/{id}', 'TicketsController@downloadFileMessage')->name('tickets.message.download.file');

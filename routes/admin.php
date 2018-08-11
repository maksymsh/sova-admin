<?php

Route::get('/', 'DashboardController@index');

Route::resource('resources', 'ResourceController');
Route::model('resource', \Sova\Admin\Models\Resource::class);
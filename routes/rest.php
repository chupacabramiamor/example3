<?php

use Illuminate\Support\Facades\Route;

Route::resource('contacts', 'ContactController')->except([ 'create', 'edit' ]);

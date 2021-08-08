<?php

use Illuminate\Http\Request;

Route::group(['middleware' => 'api'], function() {
  // fetch Contacts
  Route::get('contacts', 'Contacts@index');

  // fetch single Contact
  Route::get('contacts/{id}', 'Contacts@show');

  // add Contact
  Route::post('contacts', 'Contacts@store');

  // update Contact
  Route::patch('contacts/{id}', 'Contacts@update');

  // delete Contact
  Route::delete('contacts/{id}', 'Contacts@delete');
});
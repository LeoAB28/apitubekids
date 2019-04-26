<?php
Route::group([
	'middleware' => 'api',
], function () {


	Route::post('login', 'AuthController@login');
	Route::post('signup', 'AuthController@signup');
	Route::post('logout', 'AuthController@logout');
	Route::post('refresh', 'AuthController@refresh');
	Route::get('confirm/{email}', 'ConfirmEmailController@confirmEmail');
	Route::post('me', 'AuthController@me');
	Route::post('sendPasswordResetLink', 'ResetPasswordController@sendEmail');
	Route::post('resetPassword', 'ChangePasswordController@process');
	Route::get('profiles/{id}', 'ProfilesController@getProfilesByIdFather');
	Route::post('addProfile', 'ProfilesController@addProfile');
	Route::get('profileDelete/{id}', 'ProfilesController@destroy');
	Route::put('putProfile', 'ProfilesController@putProfile');
	Route::post('addVideo', 'PlaylistController@addVideo');
	Route::get('getVideo/{id}', 'PlaylistController@getVideo');
	Route::delete('deleteVideo/{id}', 'PlaylistController@destroy');
});
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use GuzzleHttp\Client;

Auth::routes();



//Routes (Logged In)
Route::get('/', 'HomeController@index')->name('home');
Route::get('/profile', 'HomeController@profile')->name('profile');
Route::post('/UploadController', 'UploadController@save');

/* 
resource Routes 
*/
Route::resource('test', 'testcontroller');

/*
Profile is viewed by Public

Route::get('/{username}', 'PublicProfileController@show');



//Route::get('/test', 'UploadController@test');


/* testing routes below
Route::get('/chat', 'VueController@index')->where('any', '.*');


Route::get('rehash', 'ApiTokenController@update');


Route::get('/test', function () {
    $token = 'qBBvMtgoN3DE8gtz1mibVVpScCpwBn8N6BErb0N6t6afKJEkxAzrNCRwEvoU1AlXXgwUcgei8sxLhmQF';


    $client = new Client();

    $res = $client->request('POST', 'https://localhost:8000/api/user', [
        'headers' => ['Content-Type' => 'application/json'],
        'query' => [
            'api_token' => $token
        ],
        'form_params' => [
            'api_token' => $token,
        ],
        'body' => "test"
    ]);

    // Response body content (JSON string).
    $responseJson = $res->getBody()->getContents();
    // Response body content as PHP array.
    $responseData = json_decode($responseJson, true);

    print_r($responseData);
});
*/


//Route::get('/{any}', 'VueController@index')->where('any', '.*');

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});


$app->post('api/register','UserController@register');
$app->post('api/login','UserController@login');


$app->group(['middleware' => 'checking'], function () use ($app) {
    $app->post('api/list_investment_provider','InvestmentController@list_provider');
});

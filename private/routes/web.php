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

$app->get('/', 'PrivCode@main');

$app->group(['prefix' => 'archive'], function () use ($app) {

	$app->get('/', 'PrivCode@archive');
	$app->get('/onhold', 'PrivCode@onhold');
	$app->get('/special', 'PrivCode@special');
});

$app->group(['prefix' => 'rank'], function () use ($app) {
	
	$app->get('/attacker', 'PrivCode@attackerRank');
	$app->get('/team', 'PrivCode@teamRank');
});

$app->group(['prefix' => 'notify'], function () use ($app) {
	
	$app->get('/', 'PrivCode@notify');
	$app->post('/action', 'PrivCode@action');
});

$app->group(['prefix' => 'view'], function () use ($app) {
	$app->get('/mirror/{id}', 'PrivCode@view');
	$app->get('/source/{id}', 'PrivCode@source');
	
});

$app->get('/test', 'PrivCode@test');
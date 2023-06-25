<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

    $router->get('authors', 'AuthorController@index');
    $router->get('authors/{id}', 'AuthorController@show');
    $router->post('authors', 'AuthorController@addAuthor');
    $router->delete('authors/{id}', 'AuthorController@deleteAuthor');
    $router->patch('/authors/{id}', 'AuthorController@updateAuthor');
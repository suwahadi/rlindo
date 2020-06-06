<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

	$router->resource('curriculum-vitae', CurriculumVitaeController::class);
	$router->resource('travel-document', TravelDocumentController::class);
 	$router->resource('experiences', ExperiencesController::class);
 	$router->resource('certificates', CertificatesController::class);
 	$router->resource('skills', SkillsController::class);
	$router->resource('list-certificates', ListCertificatesController::class);
	$router->resource('list-skills', ListSkillsController::class);

	// $router->resource('painters', PainterController::class);
 	// $router->get('forms/register', 'FormController@register');
});
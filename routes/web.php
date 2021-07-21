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

$router->group([
    'prefix' => 'auth'
], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->get('profile', 'AuthController@profile');
});

$router->get('/agent', 'AgentController@list');

$router->post('/campaign', 'CampaignController@create');
$router->get('/campaign', 'CampaignController@list');

$router->get('/campaign/{campaign_id}', 'CampaignController@view');
$router->post('/campaign/{campaign_id}', 'CampaignController@update');
$router->delete('/campaign/{campaign_id}', 'CampaignController@delete');

$router->get('/campaign/{campaign_id}/photo/{photo_id}', 'CampaignPhotoController@blob');
$router->get('/campaign/{campaign_id}/qr-code/{qr_id}', 'CampaignQrCodeController@blob');

$router->post('/campaign/{campaign_id}/agent', 'CampaignAgentController@create');
$router->get('/campaign/{campaign_id}/agent', 'CampaignAgentController@list');

$router->post('/campaign/{campaign_id}/contributor', 'ContributorController@create');

$router->get('/campaign/{campaign_id}/income-outcome', 'VRekapitulasiPendanaanController@list');
$router->get('/campaign/{campaign_id}/income-outcome/excel', 'VRekapitulasiPendanaanController@excel');
$router->post('/campaign/{campaign_id}/income', 'IncomeController@create');
$router->post('/campaign/{campaign_id}/outcome', 'OutcomeController@create');

$router->get('/campaign/{campaign_id}/income/{income_id}', 'IncomeController@view');
$router->get('/campaign/{campaign_id}/income/{income_id}/excel', 'IncomeController@excel');
$router->get('/campaign/{campaign_id}/outcome/{outcome_id}', 'OutcomeController@view');
$router->get('/campaign/{campaign_id}/outcome/{outcome_id}/excel', 'OutcomeController@excel');

$router->get('/distribution', 'OutcomeDistributionController@listForAgent');
$router->get('/distribution/{outcome_distribution_id}', 'OutcomeDistributionController@view');
$router->post('/distribution/{outcome_distribution_id}/distribution-point', 'OutcomeDistributionPointController@create');
$router->post('/distribution/{outcome_distribution_id}/distribution-point/do-update', 'OutcomeDistributionPointController@update');

$router->get('/outcome-evidence/{evidence_id}', 'OutcomeDistributionPointEvidenceController@blob');
$router->get('distribution-point-evidence/{point_id}', 'OutcomeDistributionPointController@packEvindence');

$router->post('/user', 'UserController@create');

$router->get('/role', 'RoleController@list');

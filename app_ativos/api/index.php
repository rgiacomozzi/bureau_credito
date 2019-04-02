<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) 
{
	$data = ['api' => 'ativos'];
	return $response->withJson($data, 200);
});

/**
 * Fontes de renda
 */
$app->get('/fontes_renda/lista/{cpf}', function (Request $request, Response $response, array $args) 
{
    $cpf = $args['cpf'];

    $data = ['fontes_renda' => ['renda_1', 'renda_2']];

	return $response->withJson($data, 200);
});

/**
 * Bens materiais
 */
$app->get('/bens_materiais/lista/{cpf}', function (Request $request, Response $response, array $args) 
{
    $cpf = $args['cpf'];

    $data = ['bens_materiais' => ['registro_1', 'registro_2']];

	return $response->withJson($data, 200);
});

$app->run();

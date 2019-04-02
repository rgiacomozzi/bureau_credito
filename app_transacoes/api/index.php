<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) 
{
    $data = ['api' => 'transacoes'];
	return $response->withJson($data, 200);
});

/**
 * Consultas ao CPF
 */
$app->get('/consultas_cpf/lista/{cpf}', function (Request $request, Response $response, array $args) 
{
    $cpf = $args['cpf'];

    $data = ['consultas_cpf' => ['consulta_1', 'consulta_2']];

	return $response->withJson($data, 200);
});
$app->get('/consultas_cpf/ultima/{cpf}', function (Request $request, Response $response, array $args) 
{
    $cpf = $args['cpf'];

    $data = ['ultima_consulta_cpf' => ['consulta_x']];

	return $response->withJson($data, 200);
});

/**
 * Compras com cartão de crédito
 */
/*ToDo*/

/**
 * Movimentações financeiras
 */
$app->get('/movimentacoes_financeiras/lista/{cpf}', function (Request $request, Response $response, array $args) 
{
    $cpf = $args['cpf'];

    $data = ['movimentacoes' => ['transaction_1', 'transaction_2']];

	return $response->withJson($data, 200);
});

$app->run();

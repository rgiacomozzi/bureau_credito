<?php
require '../vendor/autoload.php';
require 'PessoaController.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->get('/pessoas/', function (Request $request, Response $response, array $args) 
{
	$pessoa = new PessoaController();
	$result = $pessoa->lista();

	return $response->withJson($result, 200);
});

$app->get('/pessoas/{cpf}', function (Request $request, Response $response, array $args) 
{
	$cpf = $args['cpf'];

	$pessoa = new PessoaController();
	$result = $pessoa->get($cpf);

	return $response->withJson($result, 200);
});

$app->run();

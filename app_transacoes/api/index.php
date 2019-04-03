<?php
require '../vendor/autoload.php';
// require 'ElasticFactory.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Elasticsearch\ClientBuilder;

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
 * Consome recursos de ElasticSearch
 */
$app->get('/movimentacoes_financeiras/lista/{cpf}', function (Request $request, Response $response, array $args) 
{
    $cpf = $args['cpf'];

    // Instantiate a new ClientBuilder
    $client = ClientBuilder::create()
        ->setHosts(['localhost:9200'])      // Set the hosts
        ->build();              // Build the client object

    // Setup search query
    $searchParams['index'] = 'bureau';
    $searchParams['type']  = 'movimentacao_financeira';
    $searchParams['body']['query']['match']['cpf'] = $cpf;
    $queryResponse = $client->search($searchParams);
    $results = $queryResponse['hits']['hits'];

    if (count($results) > 0) {
        foreach ($results as $result) {
            $data[] = $result['_source'];
        }
        //return example
        //$data[] = '[{"cpf":"123456789","data_operacao":"29\/03\/2019 09:15","valor":"230.0","operacao":"credito"},{"cpf":"123456789","data_operacao":"01\/04\/2019 11:56","valor":"15.0","operacao":"debito"},{"cpf":"123456789","data_operacao":"29\/03\/2019 10:40","valor":"210.0","operacao":"debito"}]';
    } else {
        $data = ['error' => 'Nenhum registro encontrado'];
    }

	return $response->withJson($data, 200);
});

$app->run();

<?php
require '../../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use GuzzleHttp\Client;

$app = new \Slim\App;

$app->get('/', function (Request $request, Response $response, array $args) 
{
	$api = new GuzzleHttp\Client();

	$_cpfExemplo = '05390149904';
	$html = '';

	//Cadastro
	$html .= '<pre>
{APP cadastros}

Exemplos:
<a href="dados_cadastrais/'.$_cpfExemplo.'">Dados cadastrais do CPF</a>
</pre>';

	$html .= '<hr />';

	//Ativos
	$html .= '<pre>
{APP ativos}

Exemplos:
<a href="lista_fontes_renda/'.$_cpfExemplo.'">Lista de fontes de renda do CPF</a>
<a href="lista_bens_materiais/'.$_cpfExemplo.'">Lista de bens mateirias do CPF</a>
</pre>';

	$html .= '<hr />';

	//Transações
	$html .= '<pre>
{APP transações}

Exemplos:
<a href="ultima_consulta_cpf/'.$_cpfExemplo.'">Última consulta do CPF</a>
<a href="movimentacoes_financeiras_recentes/'.$_cpfExemplo.'">Movimentações financeiras recentes do CPF</a>
</pre>';

	return $response->getBody()->write($html);
});

/**
 * Retorna dados cadastrais do CPF
 * Consome API da aplicação APP_Cadastro
 */
$app->get('/dados_cadastrais/{cpf}', function (Request $request, Response $response, array $args) 
{
	$api = new GuzzleHttp\Client();

	$cpf = $args['cpf'];

	$response_cadastro = $api->request('GET', 'http://localhost/lab/desafio_serasac/bureau_credito/app_cadastro/api/pessoas/'.$cpf);
	$html = $response_cadastro->getBody();

	return $response->getBody()->write($html);
});

/**
 * Lista de fontes de renda do CPF
 * Consome API da aplicação APP_Ativos
 */
$app->get('/lista_fontes_renda/{cpf}', function (Request $request, Response $response, array $args) 
{
	$api = new GuzzleHttp\Client();

	$cpf = $args['cpf'];

	//Ativos
	$response_ativos = $api->request('GET', 'http://localhost/lab/desafio_serasac/bureau_credito/app_ativos/api/fontes_renda/lista/'.$cpf);
	$html = $response_ativos->getBody();

	return $response->getBody()->write($html);
});

/**
 * Lista de bens materiais do CPF
 * Consome API da aplicação APP_Ativos
 */
$app->get('/lista_bens_materiais/{cpf}', function (Request $request, Response $response, array $args) 
{
	$api = new GuzzleHttp\Client();

	$cpf = $args['cpf'];

	//Ativos
	$response_ativos = $api->request('GET', 'http://localhost/lab/desafio_serasac/bureau_credito/app_ativos/api/bens_materiais/lista/'.$cpf);
	$html = $response_ativos->getBody();

	return $response->getBody()->write($html);
});

/**
 * Última consulta ao CPF
 * Consome API da aplicação APP_Transacoes
 */
$app->get('/ultima_consulta_cpf/{cpf}', function (Request $request, Response $response, array $args) 
{
	$api = new GuzzleHttp\Client();

	$cpf = $args['cpf'];

	//Transações
	$response_transacoes = $api->request('GET', 'http://localhost/lab/desafio_serasac/bureau_credito/app_transacoes/api/consultas_cpf/ultima/'.$cpf);
	$html = $response_transacoes->getBody();

	return $response->getBody()->write($html);
});

/**
 * Movimentações financeiras do CPF
 * Consome API da aplicação APP_Transacoes
 */
$app->get('/movimentacoes_financeiras_recentes/{cpf}', function (Request $request, Response $response, array $args) 
{
	$api = new GuzzleHttp\Client();

	$cpf = $args['cpf'];

	//Transações
	$response_transacoes = $api->request('GET', 'http://localhost/lab/desafio_serasac/bureau_credito/app_transacoes/api/movimentacoes_financeiras/lista/'.$cpf);
	$html = $response_transacoes->getBody();

	return $response->getBody()->write($html);
});

$app->run();

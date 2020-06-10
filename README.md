# bureau_credito

*Esta é uma aplicação de estudo e testes*

Em uma visão geral, têm-se uma aplicação(ções) para: a) Consumir bases/recursos externos; b) Processar e tratar os dados; e c) Disponibilizar novos recursos.

A arquitetura proposta, orientada a micro-serviços, foi baseado em recursos de negócio. Ela permite separar, responsabilizar e dar automonia para os assuntos. O 'container' entra em cena como uma forma de concentrar e orquestrar os recursos utilizados.

![Alt text](diagrama_arq.png?raw=true "Arquitetura")

#### Aplicações e serviços

- Cadastro
  - dados pessoais
- Ativos
  - fontes de renda
  - bens materiais
- Transações
  - consultas ao cpf
  - compras com cartão de crédito
  - movimentações financeiras
- Container

## Cadastro

- Consumo de uma base MySQL, que fornece mecanismos de restrição/permissão de acesso aos dados
  - cpf, nome, endereço, cidade, estado, data nascimento
- Features
  - dados cadastrais do CPF
- Tecnologias
  - PHP/Mysql

## Ativos

- Consumo via API de uma base ElasticSearch
  - bens_materiais: cpf, descricao, valor, tipo[imovei|automovel|...]
  - fontes_renda: cpf, descricao, valor, periodicidade, tipo[aluguel|investimento|...]
- Features
  - lista de bens materiais
  - lista de fontes de renda
- Tecnologias
  - Slim PHP Framework

## Transações

- Consumo via API de uma base ElasticSearch, oferendo perfomance das consultas/pesquisas com grande volumes de dados
  - consultas: cpf, instituicao, data, quem_consultou
  - compras_cc: cpf, cartão de crédito, data, valor, estabelecimento
  - movimentacoes_fin: cpf, data, valor, operacao[entrada|saída]
- Features
  - última consulta realizada ao cpf
  - dados da última compra com cartão de crédito do cpf
  - lista de movimentações financeiras
- Tecnologias
  - Slim PHP Framework

## Container

A aplicação 'container' será usada para conectar os microservices, fornecendo os recursos principais e também novos recursos p/ outras aplicações ou terceiros.

- Tecnologias
  - PHP
  - GuzzleHttp (HTTP client)
  - API Rest


# Entendendo os códigos criados

No arquivo "bureau_credito/app_container/src/public/index.php", preparei exemplos de consumo das APIs criadas.

APIs consumidas pelo container
```
- {$base_uri}/app_cadastro/api/pessoas/{cpf}
- {$base_uri}/app_ativos/api/fontes_renda/lista/{cpf}
- {$base_uri}/app_ativos/api/bens_materiais/lista/{cpf}
- {$base_uri}/app_transacoes/api/consultas_cpf/ultima/{cpf}
- {$base_uri}/app_transacoes/api/movimentacoes_financeiras/lista/{cpf}
```
APIs expostas pelo container
```
- {$base_uri}/app_container/src/public/dados_cadastrais/{cpf}
- {$base_uri}/app_container/src/public/lista_fontes_renda/{cpf}
- {$base_uri}/app_container/src/public/lista_bens_materiais/{cpf}
- {$base_uri}/app_container/src/public/ultima_consulta_cpf/{cpf}
- {$base_uri}/app_container/src/public/movimentacoes_financeiras_recentes/{cpf}
```
Não implementado / problemas
- O consumo das API não foram implementados com métodos de autenticação/autorização
- No app_cadastro, não consegui usar namespace p/ chamar o PessoaController();, então usei o require

---

Script p/ a base de dados MySQL
```
CREATE DATABASE bureau_credito;

CREATE TABLE pessoa (
  id INT(6) UNSIGNED AUTO_INCREMENT,
  nome VARCHAR(255) NOT NULL,
  cpf VARCHAR(11) NOT NULL,
  endereco VARCHAR(255),
  cidade VARCHAR(255),
  estado CHAR(2),
  PRIMARY KEY (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE bureau_credito.pessoa ADD CONSTRAINT pessoa_UN UNIQUE KEY (cpf);
```

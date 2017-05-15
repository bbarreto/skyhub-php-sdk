<?php

include 'vendor/autoload.php';

use Skyhub\Marketplace;

$skyhub = new Skyhub\Marketplace();

$skyhub->setAuth('bruno.barreto@oppa.com.br', 'HZyjjsEopTqMrF5sZnWG');

header('Content-Type','application/json');

//Listar produtos
//$retorno = $skyhub->categories()->update(999999, 'Categoria de Teste Atualizada Barreto');
$retorno = $skyhub->freights();

$retorno->page = 1;
$retorno->perPage = 10;
$retorno->filtersSaleSystems = [
	'teste'
];

$retorno = $retorno->get();

print json_encode($retorno);
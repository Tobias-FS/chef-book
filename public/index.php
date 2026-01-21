<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$pdo = criarConexao();

$rotas = [
    
];

foreach( $rotas as $r ) {
    require __DIR__ .  $r;
}

$app->run();
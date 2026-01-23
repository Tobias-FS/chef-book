<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$pdo = criarConexao();

$rotas = [
    '/../src/ingrediente/rotas-ingrediente.php'
];

foreach( $rotas as $r ) {
    $f = require __DIR__ .  $r;
    $f( $app, $pdo );
}

$app->run();
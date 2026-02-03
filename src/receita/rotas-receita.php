<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function( App $app, PDO $pdo ) {
    $app->post('/receitas', function (Request $request, Response $response, $args) use ( $pdo ) {
        $controladora = new ControladoraReceitaEdicao(
            new VisaoReceita( $request, $response, $args ),
            new GestorReceita( 
                new RepositorioReceitaEmBDR( $pdo ),
                new RepositorioCategoriaEmBDR( $pdo ) )
        );

        return $controladora->adicionar();
    });
};
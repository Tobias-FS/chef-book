<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function( App $app, PDO $pdo ) {
    $app->get( '/ingredientes', function (Request $request, Response $response, $args ) use ( $pdo ) {
        $controladora = new ControladoraIngrediente(
            new VisaoIngrediente( $request, $response, $args ),
            new GestorIngrediente( new RepositorioIngredienteEmBDR( $pdo ) )
        );
    
        return $controladora->ingredientes();
    } );

    $app->get( '/ingredientes/{id}', function (Request $request, Response $response, $args ) use ( $pdo ) {
        $controladora = new ControladoraIngrediente(
            new VisaoIngrediente( $request, $response, $args ),
            new GestorIngrediente( new RepositorioIngredienteEmBDR( $pdo ) )
        );
    
        return $controladora->ingredientesComID();
    } );

    $app->post( '/ingredientes', function (Request $request, Response $response, $args ) use ( $pdo ) {
        $controladora = new ControladoraIngrediente(
            new VisaoIngrediente( $request, $response, $args ),
            new GestorIngrediente( new RepositorioIngredienteEmBDR( $pdo ) )
        );
    
        return $controladora->adicionar();
    } );
};
<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Visao {

    public function __construct( 
        protected Request $request, 
        protected Response $respose,
        protected array $args 
    ) {}

    public function obterDados(): array {
        return (array) $this->request->getParsedBody();       
    }

    public function exibirCadastradoComSuceso(): Response {
        return $this->response->withStatus( 201 );
    }

    public function exibirRemovidoComSuceso(): Response {
        return $this->response->withStatus( 204 );
    }

    public function exibirSucesso(): Response {
        return $this->response->withStatus( 200 );
    }

    public function exibirExcessao( Exception $e ): Response {
        $erroDoCliente = $e instanceof DominioException;
        $naoEcontrado = $e instanceof NaoEncontradoException;
        $status = 500;
        if ( $erroDoCliente ) {
            $status = 400;
        } else if ( $naoEcontrado ) {
            $status = 404;
        }

        $problemas = [];
        if ( $e instanceof DadosInvalidosException ) {
            $problemas = $e->getProblemas();
        } else {
            $problemas = [ $e->getMessage() ];
        }
        
        $response = $this->response
            ->withStatus( $status )
            ->withHeader( 'Content-Type', 'application/json' );
        $response->getBody()->write( json_encode( $problemas ) );
        
        return $this->response;
    }  
}
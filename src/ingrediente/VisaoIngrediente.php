<?php

use Slim\Psr7\Response;

class VisaoIngrediente extends Visao {

    public function dadosIngrediente(): array {
        return $this->obterDados();
    }

    public function idIngrediente(): string {
        return $this->args[ 'id' ] ?? '0';
    }

    public function exibirIngredientes( array $dados ): Response {
        $response = $this->response
            ->withStatus( 200 )
            ->withHeader( 'Content-Type', 'application/json' );
        $response->getBody()->write( json_encode( [ 'ingredientes' => $dados ] ) );
        return $response;
    }
}
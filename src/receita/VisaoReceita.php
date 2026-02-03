<?php

use Slim\Psr7\Response;

class VisaoReceita extends Visao {

    public function dadosReceita(): array {
        return $this->obterDados();
    }

    public function idReceita(): string {
        return $this->args[ 'id' ] ?? '0';
    }

    public function exibirReceitas( array $dados ): Response {
        $response = $this->response
            ->withStatus( 200 )
            ->withHeader( 'Content-type', 'application/json' );
        $response->getBody()->write( json_encode( [ 'receitas' => $dados ] ) );
        
        return $response;
    }
}
<?php

use Slim\Psr7\Response;

class ControladoraIngrediente {

    public function __construct(
        private VisaoIngrediente $visao,
        private GestorIngrediente $gestor,
    ) {}

    public function adicionar() {
        try {
            $dados = $this->visao->dadosIngrediente();
            $this->gestor->salvar( $dados );
            return $this->visao->exibirCadastradoComSuceso();
        } catch ( Exception $e ) {
            return $this->visao->exibirExcessao( $e );
        } 
    }

    public function ingredientes(): Response {
        try {
            $ingredientes = $this->gestor->listar();
            return $this->visao->exibirIngredientes( $ingredientes ); 
        } catch( Exception $e ) {
            return $this->visao->exibirExcessao( $e );
        }
    }

    public function ingredientesComId(): Response {
        try {
            $id = $this->visao->idIngrediente();
            $ingrediente = $this->gestor->listarComId( $id );
            return $this->visao->exibirIngredientes( (array) $ingrediente );
        } catch ( Exception $e ) {
            return $this->visao->exibirExcessao( $e );
        }
    }
}
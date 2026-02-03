<?php

use Slim\Psr7\Response;

class ControladoraIngrediente {

    public function __construct(
        private VisaoIngrediente $visao,
        private GestorIngrediente $gestor,
    ) {}

    public function adicionar(): Response {
        try {
            $dados = $this->visao->dadosIngrediente();
            $this->gestor->salvar( $dados );
            return $this->visao->exibirCadastradoComSucesso();
        } catch ( Exception $e ) {
            return $this->visao->exibirExcecao( $e );
        } 
    }

    public function alterar(): Response {
        try {
            $id = $this->visao->idIngrediente();
            $dados = $this->visao->dadosIngrediente();
            $this->gestor->atualizar( $id, $dados );
            return $this->visao->exibirSucesso();
        } catch ( Exception $e ) {
            return $this->visao->exibirExcecao( $e );
        }
    }

    public function ingredientes(): Response {
        try {
            $ingredientes = $this->gestor->listar();
            return $this->visao->exibirIngredientes( $ingredientes ); 
        } catch( Exception $e ) {
            return $this->visao->exibirExcecao( $e );
        }
    }

    public function ingredientesComId(): Response {
        try {
            $id = $this->visao->idIngrediente();
            $ingrediente = $this->gestor->listarComId( $id );
            return $this->visao->exibirIngredientes( (array) $ingrediente );
        } catch ( Exception $e ) {
            return $this->visao->exibirExcecao( $e );
        }
    }
}
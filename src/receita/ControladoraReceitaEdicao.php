<?php

use Slim\Psr7\Response;

class ControladoraReceitaEdicao {

    public function __construct(
        private VisaoReceita $visao,
        private GestorReceita $gestor
    ) {}

    public function adicionar(): Response {
        try {
            $dados = $this->visao->dadosReceita();
            $this->gestor->salvar( $dados );
            return $this->visao->exibirCadastradoComSucesso();
        } catch( Exception $e ) {
            return $this->visao->exibirExcecao( $e );
        } 
    }
}
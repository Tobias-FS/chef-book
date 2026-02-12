<?php

use Slim\Psr7\Response;

class ControladoraReceitaListagem {

    public function __construct(
        private VisaoReceita $visao,
        private GestorReceita $gestor
    ) {}

    public function receitas(): Response {
        try {
            $filtros = $this->visao->parametros();
            $receitas = $this->gestor->listar( $filtros );
            return $this->visao->exibirReceitas( $receitas );
        } catch( Exception $e ) {
            return $this->visao->exibirExcecao( $e );
        }
    }

    public function receitasComId(): Response {
        try {
            $id = $this->visao->idReceita();
            $receita = $this->gestor->listarComId( $id );
            return $this->visao->exibirReceitas( $receita );
        } catch( Exception $e ) {
            return $this->visao->exibirExcecao( $e );
        }
    }
}
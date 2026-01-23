<?php

class GestorIngrediente {

    public function __construct( 
        private  $repositorio
    ) {}

    public function listar(): array {
        return $this->repositorio->obter();
    }

    public function listarComId( string $id ): Ingrediente {
        if ( ! is_numeric( $id ) || intval( $id ) < 1 ) {
            throw DadosInvalidosException::com( [ 'O id deve ser um número positivo.' ] );
        }

        return $this->repositorio->obterComId( (int) $id );
    }
}
<?php

class GestorIngrediente {

    public function __construct( 
        private RepositorioIngrediente $repositorio
    ) {}

    public function salvar( array $dados ): void {
        $dados = sanitizar( $dados );

        if ( ! isset( $dados[ 'nome' ] ) ) {
            throw DadosInvalidosException::com( [ 'Nome do ingrediente não enviado' ] );
        }

        $ingrediente = new Ingrediente( 0, $dados[ 'nome' ] );
        $problemas = $ingrediente->validar();
        if ( $problemas ) {
            throw DadosInvalidosException::com( $problemas );
        }

        $this->repositorio->salvar( $ingrediente );
    }

    public function atualizar( string $id, array $dados ): void {
        $dados = sanitizar( $dados );

        if ( ! is_numeric( $id ) || intval( $id ) < 1 ) {
            throw DadosInvalidosException::com( [ 'O id deve ser um número positivo.' ] );
        } else if ( ! isset( $dados[ 'nome' ] ) ) {
            throw DadosInvalidosException::com( [ 'Nome do ingrediente não enviado.' ] );
        }

        $ingrediente = new Ingrediente( (int) $id, $dados[ 'nome' ] );

        $this->repositorio->atualizar( $ingrediente );
    }

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
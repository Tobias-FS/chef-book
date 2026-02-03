<?php

class RepositorioCategoriaEmBDR extends RepositorioEmBDR implements RepositorioCategoria {

    public function comNome( string $nome ): Categoria | null {
        $sql = 'SELECT * FROM categoria WHERE nome = :nome';
        $ps = $this->executar( $sql, [ 'nome' => $nome ] );
        
        $categoria = $ps->fetch();
        if ( ! $categoria ) {
            return null;
        }

        return new Categoria( 
            (int) $categoria[ 'id' ], 
            $categoria[ 'nome' ] );
    }
}
<?php

class RepositorioIngredienteEmBDR extends RepositorioEmBDR implements RepositorioIngrediente {

    public function salvar( Ingrediente $ingrediente ): void {
        $sql = 'INSERT INTO ingrediente ( nome ) VALUE ( :nome )';
        $this->executar( $sql, [ 'nome' => $ingrediente->nome ] );
        $ingrediente->id = $this->ultimoId();
    }

    public function atualizar( Ingrediente $ingrediente ): void {
        $sql = 'UPDATE ingrediente SET nome = :nome WHERE id = :id';
        $this->executar( $sql, [
            'id' => $ingrediente->id,
            'nome' => $ingrediente->nome
        ] );
    }

    public function obter(): array {
        $sql = 'SELECT * FROM ingrediente';
        $ps = $this->executar( $sql );
        $pesquisa = $ps->fetchAll();
        
        $ingredintes = [];
        foreach( $pesquisa as $p ) {
            $ingredintes []= new Ingrediente(
                (int) $p[ 'id' ],
                $p[ 'nome' ]
            );
        }

        return $ingredintes;
    }

    public function obterComId( int $id ): Ingrediente {
        $sql = 'SELECT * FROM ingrediente WHERE id = :id';
        $ps = $this->executar( $sql, [ 'id' => $id ] );
        $pesquisa = $ps->fetch();
        error_log( print_r( $pesquisa, true ));
        return new Ingrediente(
            (int) $pesquisa[ 'id' ],
            $pesquisa[ 'nome' ]
        );
    }
}
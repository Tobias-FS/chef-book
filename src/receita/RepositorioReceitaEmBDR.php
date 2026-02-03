<?php

class RepositorioReceitaEmBDR extends RepositorioEmBDR implements RepositorioReceita {

    public function salvar( Receita $receita): void {
        try {
            $this->pdo->beginTransaction();
            $sql = 'INSERT INTO receita ( nome, descricao, tempo_de_preparo, nivel, categoria__id ) 
                    VALUES ( :nome, :descricao, :tempo_de_preparo, :nivel, :categoria__id )';
            $this->executar( $sql, [
                'nome' => $receita->nome,
                'descricao' => $receita->descricao,
                'tempo_de_preparo' => $receita->tempoDePreparo,
                'nivel' => $receita->nivel->value,
                'categoria__id' => $receita->categoria->id
            ] );

            $idReceita = (int) $this->ultimoId();

            $this->salvarIngredientesReceita( $receita->ingredientes, $idReceita );

            $this->pdo->commit();
        } catch ( PDOException $e ) {
            if ( $this->pdo->inTransaction() ) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    private function salvarIngredientesReceita( array $ingredientes, int $idReceita ) {
        $sql = 'INSERT INTO ingrediente_receita ( quantidade, unidade, receita__id, ingrediente__id ) 
                    VALUES ( :quantidade, :unidade, :receita__id, :ingrediente__id )';
        foreach( $ingredientes as $i ) {
            $this->executar( $sql, [
                'quantidade' => $i->quantidade,
                'unidade' => $i->unidade,
                'receita__id' => $idReceita,
                'ingrediente__id' => $i->ingredienteId
            ] );
        }
    }
}
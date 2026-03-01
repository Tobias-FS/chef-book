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

    public function obter( array $paginacao ): array {
        $sqlIds = 'SELECT id FROM receita ORDER BY cadastrado_em LIMIT :retornar OFFSET :ignorar';
        $psIds = $this->executar( $sqlIds, [
            'retornar' => (int) $paginacao[ 'limit' ],
            'ignorar' => (int) $paginacao[ 'offset' ]
        ] );
        $ids = $psIds->fetchAll( PDO::FETCH_COLUMN );

        if ( empty( $ids ) ) {
            return [];
        }
        $idsParaConsulta = implode( ',', array_map( 'intval', $ids ) );

        $sql = <<< SQL
            SELECT 
                r.id, r.nome, r.descricao, r.tempo_de_preparo, r.nivel, r.cadastrado_em,
                c.id as id_categoria, c.nome as nome_categoria,   
                i.id as id_ingrediente, i.nome as nome_ingrediente,
                ir.quantidade, ir.unidade
            FROM receita r
            JOIN categoria c ON r.categoria__id = c.id
            JOIN ingrediente_receita ir ON ir.receita__id = r.id
            JOIN ingrediente i ON i.id = ir.ingrediente__id
            WHERE r.id IN ($idsParaConsulta)
            ORDER BY r.cadastrado_em;
        SQL;

        $ps = $this->executar( $sql );
        return $ps->fetchAll();
    }

    public function obterComId( int $id ): array {
        $sql = <<< 'SQL'
            SELECT 
            r.id, r.nome, r.descricao, r.tempo_de_preparo, r.nivel, r.cadastrado_em,
            c.id as id_categoria, c.nome as nome_categoria,   
            i.id as id_ingrediente, i.nome as nome_ingrediente,
            ir.quantidade, ir.unidade
            FROM receita r
            JOIN categoria c on r.categoria__id = c.id
            JOIN ingrediente_receita ir on ir.receita__id = r.id
            JOIN ingrediente i on i.id = ir.ingrediente__id          
            WHERE r.id = :id
        SQL;
        $ps = $this->executar( $sql, [ 'id' => $id ] );
        
        return $ps->fetchAll();
    }

    public function obterComFiltro( array $filtros, array $paginacao ): array {
        $sqlIds = 'SELECT DISTINCT r.id, r.cadastrado_em FROM receita r 
            JOIN ingrediente_receita ir_filtro ON ir_filtro.receita__id = r.id
            JOIN ingrediente i_filtro ON i_filtro.id = ir_filtro.ingrediente__id
            WHERE 1=1 ';
        
        $parametros = [];
        $sqlFiltro = '';

        if ( array_key_exists( 'nome', $filtros ) ) {
            $sqlFiltro .= ' AND r.nome LIKE :nome';
            $parametros[ 'nome' ] = '%' . $filtros[ 'nome' ] . '%';
        }
        if ( array_key_exists( 'ingrediente', $filtros ) ) {
            $sqlFiltro .= ' AND i_filtro.nome LIKE :ingrediente';
            $parametros[ 'ingrediente' ] = '%' . $filtros['ingrediente'] . '%';
        }

        $sqlIds .= $sqlFiltro;
        $sqlIds .= ' ORDER BY r.cadastrado_em LIMIT :retornar OFFSET :ignorar';
        
        $parametros['retornar'] = (int) $paginacao['limit'];
        $parametros['ignorar'] = (int) $paginacao['offset'];

        $psIds = $this->executar($sqlIds, $parametros);
        $ids = $psIds->fetchAll(PDO::FETCH_COLUMN);

        if ( empty( $ids ) ) {
            return [];
        }
        
        $idsParaConsulta = implode( ',', array_map( 'intval', $ids ) );

        $sql = <<< SQL
            SELECT r.id, r.nome, r.descricao, r.tempo_de_preparo, r.nivel, r.cadastrado_em, 
                c.id as id_categoria, c.nome as nome_categoria,   
                i.id as id_ingrediente, i.nome as nome_ingrediente,
                ir.quantidade, ir.unidade
            FROM receita r
            JOIN categoria c ON r.categoria__id = c.id
            JOIN ingrediente_receita ir ON ir.receita__id = r.id
            JOIN ingrediente i ON i.id = ir.ingrediente__id
            WHERE r.id IN ($idsParaConsulta)
            ORDER BY r.cadastrado_em
        SQL;
        
        $ps = $this->executar( $sql );
        return $ps->fetchAll();
    }
}


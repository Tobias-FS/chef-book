<?php

class RepositorioEmBDR {

    public function __construct( 
        protected PDO $pdo 
    ) {}

    public function executar( string $sql, array $parametros = [], string $mensagemErro = '' ): PDOStatement {
        try {
            $ps = $this->pdo->prepare( $sql );
            $ps->execute( $parametros );

            return $ps;
        } catch ( PDOException $e ) {
            throw new RepositorioException(
                empty( $mensagemErro ) ? $e->getMessage() : $mensagemErro,
                (int) $e->getCode(),
                $e
            );
        }
    }

    public function existeComId( int $id, string $tabela ): bool {
        $ps = $this->executar( 
            "SELECT id FROM $tabela WHERE id = :id",
            [ 'id' => $id ]
        );

        return $ps->fetchColumn() !== false;
    }

    public function removerRegistroPeloId( int $id, string $tabela ): bool {
        $ps = $this->executar( 
            "DELETE FROM $tabela WHERE id = :id", 
            [ 'id' => $id ] 
        );

        return $ps->rowCount() > 0;
    }

    public function ultimoId(): int {
        return (int) $this->pdo->lastInsertId();
    }
}
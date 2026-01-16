<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Categoria extends AbstractMigration
{
    public function up(): void
    {
        $sql = <<<'SQL'
        CREATE TABLE categoria (
            id      INT         NOT NULL AUTO_INCREMENT,
            nome    VARCHAR(20) NOT NULL,

            CONSTRAINT `pk_categoria`
                PRIMARY KEY (id),
            CONSTRAINT `unq_receita`
                UNIQUE (nome)
        ) Engine=InnoDB;
        SQL;
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute('DROP TABLE categoria');
    }
}

<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Receita extends AbstractMigration
{
    public function up(): void
    {
        $sql = <<<'SQL'
        CREATE TABLE receita (
            id                  INT                                 NOT NULL AUTO_INCREMENT,
            nome                VARCHAR(60)                         NOT NULL,
            descricao           VARCHAR(200),
            tempo_de_preparo    INT                                 NOT NULL,
            nivel               ENUM('FACIL', 'MEDIO', 'DIFICIL')   NOT NULL,
            data_de_criacao     DATE,

            categoria__id       INT                                 NOT NULL,

            CONSTRAINT `pk_receita`
                PRIMARY KEY (id),
            CONSTRAINT `fk_receita__categoria__id`
                FOREIGN KEY (categoria__id) REFERENCES categoria(id)
        ) Engine=InnoDB;
        SQL;
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute('DROP TABLE receita');
    }
}

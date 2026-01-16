<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Ingrediente extends AbstractMigration
{
    public function up(): void
    {
        $sql = <<<'SQL'
        CREATE TABLE ingrediente (
            id      INT             NOT NULL AUTO_INCREMENT,
            nome    VARCHAR(50)     NOT NULL,

            CONSTRAINT `pk_ingrediente`
                PRIMARY KEY (id),
            CONSTRAINT `unq_ingrediente`
                UNIQUE (nome)
        ) Engine=InnoDB;
        SQL;
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute('DROP TABLE ingrediente');
    }
}

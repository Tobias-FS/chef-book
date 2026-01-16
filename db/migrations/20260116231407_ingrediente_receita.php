<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class IngredienteReceita extends AbstractMigration
{
    public function up(): void
    {
        $sql = <<<'SQL'
        CREATE TABLE ingrediente_receita ( 
            id              INT             NOT NULL AUTO_INCREMENT,
            quantidade      INT             NOT NULL,
            unidade         VARCHAR(20),

            receita__id     INT             NOT NULL,
            ingrediente__id INT             NOT NULL,

            CONSTRAINT `pk_fk_ingrediente_receita`
                PRIMARY KEY (id),
            CONSTRAINT `fk_ingrediente_receita__receita__id`
                FOREIGN KEY (receita__id) REFERENCES receita(id),
            CONSTRAINT `fk_ingrediente_receita__ingrediente__id`
                FOREIGN KEY (ingrediente__id) REFERENCES ingrediente(id)
        ) Engine=InnoDB;
        SQL;
        $this->execute($sql);
    }

    public function down(): void
    {
        $this->execute('DROP TABLE ingrediente_receita');
    }
}

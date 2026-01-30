<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RenomearDataCriacaoEmReceita extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table( 'receita' );
        $table->removeColumn( 'data_de_criacao' );

        $table->addColumn( 'cadastrado_em', 'datetime', [
            'null' => false,
            'default' => 'CURRENT_TIMESTAMP'
        ] );

        $table->update();
    }
}

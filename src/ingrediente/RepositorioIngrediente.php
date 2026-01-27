<?php

interface RepositorioIngrediente {
    
    /**
     * Retorna todas os ingredientes.
     *
     * @return array<Ingrediente>
     */
    public function obter(): array;

    /**
     * Retorna um ingrediente expecifico.
     *
     * @return Ingrediente
     */
    public function obterComId( int $id ): Ingrediente;

    /**
     * Salva um ingrediente
     * 
     */
    public function salvar( Ingrediente $ingrediente ): void;
}
<?php

interface RepositorioCategoria {

    /**
     * 
     * Retorna a categoria com o nome informado, ou null
     */
    function comNome( string $nome ): Categoria | null;
}
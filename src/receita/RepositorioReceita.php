<?php

interface RepositorioReceita {

    function salvar( Receita $receita ): void;
    function obter( array $paginacao );
    function obterComId( int $id );
    function obterComFiltro( array $filtros, array $paginacao );
}
<?php

interface RepositorioReceita {

    function salvar( Receita $receita ): void;
    function obter();
    function obterComId( int $id );
    function obterComFiltro( array $filtros );
}
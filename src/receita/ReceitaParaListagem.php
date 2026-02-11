<?php

class ReceitaParaListagem {

    public function __construct(
        public int $id, 
        public string $nome,
        public string $descricao,
        public string $tempoDePreparo,
        public string $nivel,
        public string $dataCriacao,
        public string $categoria,
        public string $idCategoria,
        public array $ingredientes
    ) {}
}
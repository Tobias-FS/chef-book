<?php

class ReceitaListagem {

    public function __construct(
        public string $nome,
        public string $descricao,
        public string $tempoDePreparo,
        public string $nivel,
        public string $dataCricao,
        public string $categoria
    ) {}
}
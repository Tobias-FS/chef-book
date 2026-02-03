<?php

class Categoria {

    public function __construct( 
        public int $id,
        public string $nome
    ) {}

    public function validar(): array {
        $prolemas = [];

        return $prolemas;
    }
}
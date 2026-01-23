<?php

class Ingrediente {

    public function __construct(
        public int $id = 0,
        public string $nome = ''
    ) {}

    public function validar(): array {
        $problemas = [];

        return $problemas;
    }
}
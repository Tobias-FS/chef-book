<?php

class Ingrediente {

    public function __construct(
        public int $id = 0,
        public string $nome = ''
    ) {}

    public function validar(): array {
        $problemas = [];

        if ( strlen( $this->nome ) < 2 || strlen( $this->nome ) > 50 ) {
            $problemas []= 'O nome deve ter entre 2 e 50 caracteres.';
        }

        return $problemas;
    }
}
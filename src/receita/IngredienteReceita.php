<?php

class IngredienteReceita {

    public function __construct(
        public int $id = 0,
        public int $quantidade,
        public string $unidade,
        public int $receitaId,
        public int $ingredienteId,
    ) {}
}
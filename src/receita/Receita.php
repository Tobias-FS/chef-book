<?php

class Receita {

     /**
     * @param IngredienteReceita[] $ingredientes
     */
    public function __construct(
        public int $id,
        public string $nome,
        public string $descricao,
        public int $tempoDePreparo,
        public Nivel $nivel,
        public Categoria $categoria,
        public array $ingredientes,
        public ?DateTime $cadastrado_em = null
    ) {}

    public function validar(): array {
        $problemas = [];

        if ( strlen( $this->nome ) < 10 || strlen( $this->nome ) > 60 ) {
            $problemas [] = 'O nome da receita deve ter entre 10 e 60 caracteres.';
        } 
        if ( $this->descricao === '' ) {
            $problemas [] = 'A descição não pode der vazia';
        } 
        if ( $this->tempoDePreparo <= 0 ) {
            $problemas [] = 'O tempo de preparo deve ser maior que 0.';
        } 
        if ( empty( $this->ingredientes ) ) {
            $problemas [] = 'Não é pissvel cadastrar uma receita sem ingrdientes.';
        } else {
            foreach( $this->ingredientes as $i ) {
                if ( ! $i instanceof IngredienteReceita ) {
                    $problemas[] = 'Ingrediente inválido.';
                    break;
                }
            }
        }

        return $problemas;
    }
}
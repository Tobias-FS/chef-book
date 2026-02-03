<?php

use Slim\Psr7\Response;

class GestorReceita {

    public function __construct(
        private RepositorioReceita $repositorioReceita,
        private RepositorioCategoria $repositorioCategoria
    ) {}

    public function salvar( array $dados ): void {
        
        if ( ! isset( $dados[ 'nome' ], 
        $dados[ 'descricao' ],
        $dados[ 'tempoDePreparo' ],
        $dados[ 'nivel' ],
        $dados[ 'categoria' ], 
        $dados[ 'ingredientes' ]  ) ) {
            throw DadosInvalidosException::com( [ 'Nome, descrição, tempo de preparo, nivel ou categoria não enviados' ] );
        }
        
        $dados = sanitizar( $dados );

        $categoria = $this->repositorioCategoria->comNome( $dados[ 'categoria' ] );
        if ( $categoria === null ) {
            throw DadosInvalidosException::com( [ 'Categoria não cadastrada.' ] );
        }

        $ingredientesReceita = [];
        foreach( $dados[ 'ingredientes' ] as $i ) {
            $ingredientesReceita []= new IngredienteReceita( 
                0,
                (int) $i[ 'quantidade' ], 
                $i[ 'unidade' ],
                0,
                $i[ 'ingredienteId' ] );
        }

        $receita = new Receita(
            0,
            $dados[ 'nome' ],
            $dados[ 'descricao' ],
            (int) $dados[ 'tempoDePreparo' ],
            Nivel::from( $dados[ 'nivel' ] ),
            $categoria,
            $ingredientesReceita
        );

        $problemasReceita = $receita->validar();
        if ( $problemasReceita ) {
            throw DadosInvalidosException::com( $problemasReceita );
        }

        $this->repositorioReceita->salvar($receita);
    }
}
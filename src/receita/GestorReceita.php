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

    public function listar(): array {
        $linhas = $this->repositorioReceita->obter();
        return $this->instanciarReceitas( $linhas );
    }

    public function listarComId( string $id ): array {
        if ( ! is_numeric( $id ) || intval( $id ) < 1 ) {
            throw DadosInvalidosException::com( [ 'Id deve ser um numero positivo' ] );
        }

        $linhas = $this->repositorioReceita->obterComId( $id );
        return $this->instanciarReceitas( $linhas );
    }

    private function instanciarReceitas( array $linhas ): array {
        $dados = [];
        foreach( $linhas as $f ) {
            $idReceita = $f[ 'id' ];
            if ( isset( $dados[ $idReceita ] ) ) {
                $dados[ $idReceita ]->ingredientes []= [
                    "id_ingrediente" => $f[ 'id_ingrediente' ],
                    "nome_ingrediente" => $f[ 'nome_ingrediente' ],
                    "quantidade" => $f[ 'quantidade' ],
                    "unidade" => $f[ 'unidade' ]
                ];
            } else {
                $dados[ $idReceita ] = new ReceitaParaListagem(
                    $f[ 'id' ],
                    $f[ 'nome' ],
                    $f[ 'descricao' ],
                    $f[ 'tempo_de_preparo' ],
                    $f[ 'nivel' ],
                    $f[ 'cadastrado_em' ],
                    $f[ 'nome_categoria'  ],
                    $f[ 'id_categoria' ],
                    [
                        [
                            "id_ingrediente" => $f[ 'id_ingrediente' ],
                            "nome_ingrediente" => $f[ 'nome_ingrediente' ],
                            "quantidade" => $f[ 'quantidade' ],
                            "unidade" => $f[ 'unidade' ]
                        ]
                    ]
                );
            }
        }
        
        return array_values( $dados );
    }
}
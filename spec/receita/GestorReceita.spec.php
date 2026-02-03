<?php

use Kahlan\Plugin\Double;

use function Kahlan\allow;
use function Kahlan\describe;
use function Kahlan\expect;
use function Kahlan\it;

describe( 'Gestor Receita', function() {
    describe( 'salvar()', function() {
        it( 'Deve lançar exceção caso algum dos dados não for enviado.', function() {
            $repositorioReceita = Double::instance( [ 'implements' => 'RepositorioReceita' ] );
            $repositorioCategoria = Double::instance( [ 'implements' => 'RepositorioCategoria' ] );
            $dados = [
                "nome" => "Macarronada",
                "descricao" => "Bota tudo na panela" 
            ];

            $gestor = new GestorReceita( $repositorioReceita, $repositorioCategoria );

            $closure = function() use ( $gestor, $dados ) {
                $gestor->salvar( $dados );
            };

            expect( $closure )->toThrow( new DadosInvalidosException() );
        } );

        it( 'Deve lançar exceção caso a categoria não exista', function() {
            $repositorioReceita = Double::instance( [ 'implements' => 'RepositorioReceita' ] );
            $repositorioCategoria = Double::instance( [ 'implements' => 'RepositorioCategoria' ] );
            allow( $repositorioCategoria )->toReceive( 'comNome' )->andReturn( null );
            $dados = [
                "nome" => "Macarronada",
                "descricao" => "Bota tudo na panela",
                "tempoDePreparo" => 90,
                "nivel" => "FACIL",
                "categoria" => "Salgado",
                "ingredientes" => [
                    
                ]
            ];

            $gestor = new GestorReceita( $repositorioReceita, $repositorioCategoria );

            $closure = function() use ( $gestor, $dados ) {
                $gestor->salvar( $dados );
            };

            expect( $closure )->toThrow( new DadosInvalidosException() );
        } );
    } );
} );
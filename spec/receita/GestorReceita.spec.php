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

    describe( 'listar()', function() {
        it( 'Deve chamar obter() se $filtros for vazio', function() {
            $repositorioReceita = Double::instance( [ 'implements' => 'RepositorioReceita' ] );
            $repositorioCategoria = Double::instance( [ 'implements' => 'RepositorioCategoria' ] );
            $dados = [[
                'id' => 1,
                'nome' => 'Bolo',
                'descricao' => 'Bom',
                'tempo_de_preparo' => 30,
                'nivel' => 'FACIL',
                'cadastrado_em' => '2023-01-01',
                'nome_categoria' => 'Doces',
                'id_categoria' => 2,
                'id_ingrediente' => 10,
                'nome_ingrediente' => 'Açúcar',
                'quantidade' => 1,
                'unidade' => 'kg'
            ]];
                    
            allow( $repositorioReceita )->toReceive('obter')->andReturn( $dados );
            $gestor = new GestorReceita( $repositorioReceita, $repositorioCategoria );

            $resultado = $gestor->listar([]);
            expect( $resultado )->toBeAn( 'array' );
            expect( $resultado[0]->nome )->toBe( 'Bolo' );
        } );

        it( 'Deve chamar obterComFiltro() se $filtros não for vazio', function() {
            $repositorioReceita = Double::instance( [ 'implements' => 'RepositorioReceita' ] );
            $repositorioCategoria = Double::instance( [ 'implements' => 'RepositorioCategoria' ] );
            $dados = [[
                'id' => 1,
                'nome' => 'Bolo',
                'descricao' => 'Bom',
                'tempo_de_preparo' => 30,
                'nivel' => 'FACIL',
                'cadastrado_em' => '2023-01-01',
                'nome_categoria' => 'Doces',
                'id_categoria' => 2,
                'id_ingrediente' => 10,
                'nome_ingrediente' => 'Açúcar',
                'quantidade' => 1,
                'unidade' => 'kg'
            ]];

            allow( $repositorioReceita )->toReceive('obterComFiltro')->andReturn( $dados );
            $gestor = new GestorReceita( $repositorioReceita, $repositorioCategoria );

            $resultado = $gestor->listar( [ 'nome' => 'bolo' ] );
            expect( $resultado )->toBeAn( 'array' );
            expect( $resultado[0]->nome )->toBe( 'Bolo' );
        } );
    } );
    
    describe( 'listarComId()', function() {
        it( 'Deve lançar exceção se o id for invalido', function() {
            $repositorioReceita = Double::instance( [ 'implements' => 'RepositorioReceita' ] );
            $repositorioCategoria = Double::instance( [ 'implements' => 'RepositorioCategoria' ] );

            $gestor = new GestorReceita( $repositorioReceita, $repositorioCategoria );
            $closure = function() use( $gestor ) {
                $gestor->listarComId( 'a' );
            };

            expect( $closure )->toThrow( new DadosInvalidosException );
        } );
    } );
} );
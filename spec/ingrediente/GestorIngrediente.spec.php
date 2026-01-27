<?php

use Kahlan\Plugin\Double;

use function Kahlan\describe;
use function Kahlan\expect;
use function Kahlan\it;

describe( "GestorIngrediente", function() {
    describe( "listarComId()", function() {
        it( "deve retornar erro caso id não for um numero", function() {
            $repo = Double::instance( [ 'implements' => 'RepositorioIngrediente' ] );
            $gestor = new GestorIngrediente( $repo );

            $id = '1a';
            $closure = function() use ( $id, $gestor ) {
                $gestor->listarComId( $id );
            };

            expect( $closure )->toThrow( new DadosInvalidosException() );
        } );
        
        it( "deve retornar erro caso id for um numero neagativo", function() {
            $repo = Double::instance( [ 'implements' => 'RepositorioIngrediente' ] );
            $gestor = new GestorIngrediente( $repo );

            $id = '-2';
            $closure = function() use ( $id, $gestor ) {
                $gestor->listarComId( $id );
            };

            expect( $closure )->toThrow( new DadosInvalidosException() );
        } );
    } );

    describe( "salvar()", function() {
        it( "Deve retornar erro cado nome não for enviado", function() {
            $repo = Double::instance( [ 'implements' => 'RepositorioIngrediente' ] );
            $gestor = new GestorIngrediente( $repo );
            
            $dados = [];
            $closure = function() use( $gestor, $dados ) {
                $gestor->salvar( $dados );
            };

            expect( $closure )->toThrow( new DadosInvalidosException() );
        } );
    } );
} );
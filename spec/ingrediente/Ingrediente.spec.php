<?php

use Kahlan\Plugin\Double;

use function Kahlan\describe;
use function Kahlan\expect;
use function Kahlan\it;

describe( 'Ingrediente', function() {
    describe( 'validar()', function() {
        it( "Deve retornar prolemas caso nome não tenha entre 2 e 50 caracteres.", function() {
            $i = new Ingrediente( 
                0,
                'A'
            );

            $problemas = $i->validar();

            expect( $problemas )->toContain( 'O nome deve ter entre 2 e 50 caracteres.' );
        } );
    } );
} );
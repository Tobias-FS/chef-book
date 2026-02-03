<?php

use function Kahlan\describe;
use function Kahlan\expect;
use function Kahlan\it;

describe( 'Receita', function() {
    describe( 'validar()', function() {
        it( 'Deve retonar problema caso o nome seja menor que 10 caracteres', function() {
            $categoria = new Categoria( 0, 'categoria' );
            $nivel = Nivel::from( 'FACIL' );
            $receita = new Receita(
                0,
                'teste',
                'descrição teste',
                60,
                $nivel,
                $categoria,
                [ [
                    "ingredienteId" =>  2,
                    "quantidade" => "200",
                    "unidade" => "ml"
                ] ]
            );

            $problemas = $receita->validar();
        
            expect( $problemas )->toContain( 'O nome da receita deve ter entre 10 e 60 caracteres.' );
        } );

        it('retorna problema quando há ingrediente inválido na lista', function () {
            $categoria = new Categoria( 0, 'categoria' );
            $nivel = Nivel::from( 'FACIL' );
            $receita = new Receita(
                0,
                'teste',
                'descrição teste',
                60,
                $nivel,
                $categoria,
                [ [
                    "ingredienteId" =>  2,
                    "quantidade" => "200",
                    "unidade" => "ml"
                ] ]
            );

            $problemas = $receita->validar();

            expect($problemas)->toContain(
                'Ingrediente inválido.'
            );
        });
    } );
} );
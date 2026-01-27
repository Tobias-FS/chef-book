<?php

function sanitizar( mixed $a ): mixed {

    if ( is_array( $a ) || is_object( $a ) ) {
        $saida = [];
        foreach ( ( (array) $a ) as $chave => $valor ) {
            $saida[ $chave ] = sanitizar( $valor );
        }
        return $saida;
    }

    return htmlspecialchars(
        (string) $a,
        ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401,
        'UTF-8'
    );
}
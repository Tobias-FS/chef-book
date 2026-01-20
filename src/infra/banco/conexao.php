<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

function criarConexao() {
    return new PDO( 
        "mysql:dbname={$_ENV['DB_NAME']};host={$_ENV['DB_HOST']};charset=utf8",
        $_ENV[ 'DB_USER' ],
        $_ENV[ 'DB_PASS' ],
        [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ] );
}
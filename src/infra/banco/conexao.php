<?php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../../');
$dotenv->load();

function criarConexao() {
    return new PDO( 
        "mysql:dbname=chef-book;host=127.0.0.1;charset=utf8",
        $_ENV[ 'DB_USER' ],
        $_ENV[ 'DB_PASS' ],
        [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ] );
}
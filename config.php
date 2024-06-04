<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'ggmarket';


$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);


if ($conexao->connect_error) {
    die("Conexão falhou: " . $conexao->connect_error);
}

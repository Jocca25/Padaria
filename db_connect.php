<?php

$host = '127.0.0.1';
$username = 'root';
$password = 'Sunnysql1906!';  
$dbname = 'basedados_padaria';  


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>

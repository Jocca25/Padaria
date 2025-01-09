<?php
include('db_connect.php'); 

if ($conn) {
    echo "bem-sucedida ao banco de dados!";
} else {
    echo "Falha!";
}
?>

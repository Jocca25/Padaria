<?php

include('db_connect.php');


$sql = "SELECT produtos.nome, vendas.quantidade
        FROM vendas
        JOIN produtos ON vendas.id_produto = produtos.ID;";
$result = $conn->query($sql);


$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; 
    }
}


$conn->close();


$data_json = json_encode($data);
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>

</body>
</html>

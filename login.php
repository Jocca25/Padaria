<?php

include('db_connect.php'); 


$email = $_POST['email'];  
$password = $_POST['password'];


$sql = "SELECT * FROM Utilizadores WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();


if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    if ($password === $row['password']) {
        
        header("Location: Quadro.html");
        exit;
    } else {
        echo "Senha incorreta!";
    }
} else {
    echo "Email não encontrado!";
}

$conn->close();
?>

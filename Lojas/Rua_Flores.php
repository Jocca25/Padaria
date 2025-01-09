<?php

include('/Applications/MAMP/htdocs/Padaria/db_connect.php');


$sql = "SELECT p.nome AS produto, SUM(v.quantidade) AS total_vendido
FROM Produtos p
JOIN Vendas v ON p.ID = v.id_produto
JOIN Stock_Lojas sl ON p.ID = sl.id_produto
WHERE sl.id_loja = 1
GROUP BY p.nome;";
$result = $conn->query($sql);


$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row; // Adiciona cada linha do resultado ao array
    }
}


$sql2 = "SELECT p.nome AS produto, sl.quantidade AS estoque_atual
FROM Stock_Lojas sl
JOIN Produtos p ON sl.id_produto = p.ID
WHERE sl.id_loja = 1;";
$result2 = $conn->query($sql2);


$data2 = array();

if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $data2[] = $row2; 
    }
}


$conn->close();


$data_json = json_encode($data);
$data2_json = json_encode($data2);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padaria Portuguesa</title>
    <link rel="stylesheet" href="../position/Rua_Flores.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>

<body>
    <header>
        <h3 class="Logo" onclick="window.location.href='Quadro.html';">Padaria Portuguesa</h3>
    </header>
    <main>
    <div class="Quadro_branco">
            <h2 class="titulo_loja">Rua das Flores, 123</h2>
            <button class="bt_voltar" onclick="window.location.href='../Dashboard.php';">Voltar</button>
            <canvas id="grafico"></canvas> 
            <canvas id="grafico2"></canvas> 

            <script>
            
            const data = <?php echo $data_json; ?>;

            
            const labels = data.map(item => item.produto); 
            const quantities = data.map(item => item.total_vendido);

            
            const ctx = document.getElementById('grafico').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'bar', 
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Quantidade Vendida',
                        data: quantities,
                        backgroundColor: 'rgb(60, 60, 60, 0.8)',
                        borderColor: '#6f6237',  
                        borderWidth: 1
                    }]
                },
                options: {
        responsive: false, 
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true 
            }
        }
    }
});

           
            const data2 = <?php echo $data2_json; ?>;

            
            const labels2 = data2.map(item => item.produto);
            const quantities2 = data2.map(item => item.estoque_atual); 

            
            const ctx2 = document.getElementById('grafico2').getContext('2d');
            const myChart2 = new Chart(ctx2, {
                type: 'bar', 
                data: {
                    labels: labels2, 
                    datasets: [{
                        label: 'Quantidade em Stock',
                        data: quantities2,
                        backgroundColor: 'rgb(60, 60, 60, 0.8)',
                        borderColor: '#6f6237',  
                        borderWidth: 1
                    }]
                },
                options: {
        responsive: false, 
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                display: true 
            }
        }
    }
});
            </script>
        </div>
    </main>

    <footer>
        <div class="Footer-content">
            <div class="Log_in_lojas">
                <a class="Log_in_footer" href="Login.html">Log In</a>
                <a class="Feedback_footer" href="Feedback.html">Feedback</a>
                <a class="Lojas" href="Lojas.html">Lojas</a>
            </div>
            <div class="Retangulo"></div>
            <div class="Info">
                <div class="Telefone_group">
                    <img class="Telefone" src="../imagem/call_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Telefone">
                    <h4 class="Numero">Assistência 24h:<br>961227777</h4>
                </div>
                <div class="Email_info">
                    <img class="Caixa_email" src="../imagem/mail_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Email">
                    <h4 class="Email">assistencia@gmail.com</h4>
                </div>
                <p class="Direito_reservado">© 2024 Padaria Portuguesa. Todos os direitos reservados.</p>
            </div>
        </div>
        <div class="Footer-bottom">
            <div class="Links_adicionais">
                <a class="Suporte" href="https://support.apple.com/pt-pt">Suporte</a>
                <a class="Privacidade" href="politicas/politica_privacidade.html">Política de Privacidade</a>
                <a class="Termo" href="">Termos e Condições</a>
            </div>
            <img class="Qualidade" src="../imagem/pngegg.png" alt="Qualidade">
        </div>
    </footer>
</body>
</html>

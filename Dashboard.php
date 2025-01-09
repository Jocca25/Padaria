<?php

include('db_connect.php');


$sql = "SELECT produtos.nome, vendas.quantidade
        FROM vendas
        JOIN produtos ON vendas.id_produto = produtos.ID order by 1;";
$result = $conn->query($sql);


$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}


$sql2 = "SELECT P.nome AS Produto, SUM(SL.quantidade) AS Quantidade_Total
         FROM Stock_Lojas SL
         JOIN Produtos P ON SL.id_produto = P.ID
         GROUP BY P.nome
         ORDER BY P.nome;";
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
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="position/Dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>

<body>
    <header>
        <h3 class="Logo" onclick="window.location.href='Quadro.html';">Padaria Portuguesa</h3>
        <button class="butao_back" onclick="window.location.href='Quadro.html';"> < Main Page</button>
    </header>
    <main>

        <div class="Quadro_branco">
        <h2 class="Titulo_2">Dashboard</h2>
            <button class="Loja_2" onclick="window.location.href='../Padaria/Lojas/Avenida_principal.php';">Avenida Principal, 45</button>
            <button class="Loja_1" onclick="window.location.href='../Padaria/Lojas/Rua_Flores.php';">Rua das Flores, 123</button>
            <button class="Loja_3" onclick="window.location.href='../Padaria/Lojas/Praça_alegria.php';">Praça da Alegria, 67</button>
            <button class="Loja_4" onclick="window.location.href='../Padaria/Lojas/Rua_comercio.php';">Rua do Comércio, 89</button>
            <button class="mais" onclick="window.location.href='Mais.php';">Mais ></button>
                
                <canvas id="grafico"></canvas>
                
                
                <canvas id="grafico2"></canvas>

                <script>
                
                const data = <?php echo $data_json; ?>;

                
                const labels = data.map(item => item.nome); 
                const quantities = data.map(item => item.quantidade); 
                const ctx = document.getElementById('grafico').getContext('2d');
                const myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Quantidade Vendida Total',
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

                
                const labels2 = data2.map(item => item.Produto); 
                const quantities2 = data2.map(item => item.Quantidade_Total);

                
                const ctx2 = document.getElementById('grafico2').getContext('2d');
                const myChart2 = new Chart(ctx2, {
                    type: 'bar', 
                    data: {
                        labels: labels2,
                        datasets: [{
                            label: 'Quantidade em Stock Total',
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
                <a class="Log_in_footer" href="Dashboard.php">Dashboard</a>
                <a class="Feedback_footer" href="feed/HTML.html">Feedback</a>
                <a class="Lojas" href="suporte/htmll.html">Suporte</a>
            </div>
            <div class="Retangulo"></div>
            <div class="Info">
                <div class="Telefone_group">
                    <img class="Telefone" src="imagem/call_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Telefone">
                    <h4 class="Numero">Assistência 24h:<br>961227777</h4>
                </div>
                <div class="Email_info">
                    <img class="Caixa_email" src="imagem/mail_24dp_FFFFFF_FILL0_wght400_GRAD0_opsz24.png" alt="Email">
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
            <img class="Qualidade" src="imagem/pngegg.png" alt="Qualidade">
        </div>
    </footer>
</body>
</html>

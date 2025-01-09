<?php

include('db_connect.php');

// SQL para faixa etária
$sql = "SELECT 
CASE 
    when idade between 0 and 20 then '0-20'
    when idade between 21 and 40 then '21-40'
    when idade between 41 and 60 then '41-60'
    when idade > 60 then '61+'
end as faixa_etaria,
COUNT(*) as total_clientes
from clientes
group by faixa_etaria
order by faixa_etaria;";

$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

$sql_sexo = "SELECT sexo, COUNT(*) AS total_clientes
             FROM clientes
             GROUP BY sexo";
$result_sexo = $conn->query($sql_sexo);

$sexo_data = array();
if ($result_sexo->num_rows > 0) {
    while ($row_sexo = $result_sexo->fetch_assoc()) {
        $sexo_data[] = $row_sexo;
    }
}

$sql_desvio = "SELECT STDDEV(idade) AS desvio_padrao_idade FROM clientes";
$result_desvio = $conn->query($sql_desvio);
$desvio_data = array();
if ($result_desvio->num_rows > 0) {
    $row = $result_desvio->fetch_assoc();
    $desvio_data[] = $row['desvio_padrao_idade']; 
} else {
    $desvio_data[] = 0;
}

$sql_desvio_vendas = "SELECT v.id, v.id_cliente, p.nome as produto, v.quantidade, p.valor, 
(v.quantidade * p.valor) as valor_total
from vendas v
join produtos p on v.id_produto = p.id
order by valor_total desc
limit 1;";
$result_desvio_vendas = $conn->query($sql_desvio_vendas);
$desvio_data_vendas = array();
if ($result_desvio_vendas->num_rows > 0) {
    $row = $result_desvio_vendas->fetch_assoc();
    $desvio_data_vendas[] = $row['valor_total']; // Corrigido: deve ser valor_total, não desvio_padrao_vendas
} else {
    $desvio_data_vendas[] = 0;
}

$conn->close();

$data_json = json_encode($data);
$sexo_json = json_encode($sexo_data);
$desvio_json = $desvio_data[0]; 
$desvio_vendas_json = $desvio_data_vendas[0];
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padaria Portuguesa</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="position/Mais.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 
</head>
<body>
    <header>
        <h3 class="Logo" onclick="window.location.href='Quadro.html';">Padaria Portuguesa</h3>
        <button class="butao_back" onclick="window.location.href='Dashboard.php';"> < Dashboard</button>
    </header>
    <main>
        <div class="Quadro_branco">
            <h2 class="Titulo_2">Dashboard</h2>

            <button class="Loja_2" onclick="window.location.href='../Padaria/Lojas/Avenida_principal.php';">Avenida Principal, 45</button>
            <button class="Loja_1" onclick="window.location.href='../Padaria/Lojas/Rua_Flores.php';">Rua das Flores, 123</button>
            <button class="Loja_3" onclick="window.location.href='../Padaria/Lojas/Praça_alegria.php';">Praça da Alegria, 67</button>
            <button class="Loja_4" onclick="window.location.href='../Padaria/Lojas/Praça_alegria.php';">Rua do Comércio, 89</button>
            <button class="mais" onclick="window.location.href='Dashboard.php';"> < Voltar</button>
            <h2 class="Desvio_local">Desvio Padrão da Idade: <span id="desvioPadrao" class="Numero_2"></span></h2>
            <h2 class="maior_venda">Maior Venda: <span id="desvioPadraoVendas" class="Numero_2"></span></h2>

            <div class="container-graficos">
                <canvas id="grafico1" width="800" height="350"></canvas>
                <canvas id="graficoPizza" width="400" height="400"></canvas>
            </div>
            <script>
                const data1 = <?php echo $data_json; ?>;
                const labels1 = data1.map(item => item.faixa_etaria);
                const quantities1 = data1.map(item => item.total_clientes);
                
                const ctx1 = document.getElementById('grafico1').getContext('2d');
                new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: labels1,
                        datasets: [{
                            label: 'Número de Clientes por Faixa Etária',
                            data: quantities1,
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

                const dataSexo = <?php echo $sexo_json; ?>;
                const labelsSexo = dataSexo.map(item => {
                    return item.sexo === 'M' ? 'Masculino' : 'Feminino';
                });
                const valuesSexo = dataSexo.map(item => item.total_clientes);

                const ctx2 = document.getElementById('graficoPizza').getContext('2d');
                new Chart(ctx2, {
                    type: 'pie',
                    data: {
                        labels: labelsSexo, 
                        datasets: [{
                            label: 'Proporção de Gênero',
                            data: valuesSexo,
                            backgroundColor: ['#36a2eb', '#ff6384'],  
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: false,
                        plugins: {
                            legend: {
                                position: 'top',
                                display: true
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' clientes';
                                    }
                                }
                            }
                        }
                    }
                });

                window.onload = function() {
                    const desvio = <?php echo $desvio_json; ?>;
                    console.log(desvio); 
                    document.getElementById('desvioPadrao').innerText = desvio.toFixed(2);

                    const desvio_vendas = <?php echo $desvio_vendas_json; ?>;
                    console.log(desvio_vendas); 
                    document.getElementById('desvioPadraoVendas').innerText = desvio_vendas.toFixed(2)+'€';
                };
            </script>

        </div>
    </main>
    <footer>
        <div class="Footer-content">
            <div class="Log_in_lojas">
                <a class="Log_in_footer" href="Login.html">Log In</a>
                <a class="Feedback" href="Feedback.html">Feedback</a>
                <a class="Lojas" href="Lojas.html">Lojas</a>
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
                <h5 class="Suporte">Suporte</h5>
                <h5 class="Privacidade">Política de Privacidade</h5>
                <h5 class="Termo">Termos e Condições</h5>
            </div>
            <img class="Qualidade" src="imagem/pngegg.png" alt="Qualidade">
        </div>
    </footer>
</body>
</html>

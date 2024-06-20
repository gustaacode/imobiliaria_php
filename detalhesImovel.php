<?php
// Verifica se o ID do imóvel foi passado via GET
if (isset($_GET['cd_imovel'])) {
    $imovelId = $_GET['cd_imovel'];

    // Configurações da conexão com o banco de dados (substitua pelas suas configurações)
    require_once 'conexao.php';

    // Cria uma instância da classe Database
    $db = new Database();
    $pdo = $db->getConnection();

    // Prepara a query SQL para buscar as informações detalhadas do imóvel
    $sql = "SELECT * FROM imovel WHERE cd_imovel = :cd_imovel";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':cd_imovel', $imovelId, PDO::PARAM_INT);
        $stmt->execute();
        $imovel = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$imovel) {
            die("Imóvel não encontrado.");
        }
    } catch (PDOException $e) {
        die("Erro ao executar consulta: " . $e->getMessage());
    }
} else {
    die("ID do imóvel não fornecido.");
}

// Função para converter valor de venda ou aluguel para SIM ou NÃO
function converterParaSimOuNao($valor)
{
    return $valor == 'S' ? 'Sim' : 'Não';
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Detalhes do Imóvel</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('https://extensaodigital.com/wp-content/uploads/2021/01/Marketing-Digital-para-Imobiliarias.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.5);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            max-width: 700px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
        }

        .card {
            display: flex;
            flex-direction: column;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .card img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            object-position: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card-content h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            font-weight: bold;
            color: #333;
        }

        .card-content p {
            margin-bottom: 5px;
            font-size: 1rem;
            line-height: 1.6;
            color: #555;
        }

        .card-content .property-info {
            display: flex;
            justify-content: space-between;
        }

        .card-content .property-info p {
            flex: 1;
        }

        .card-content a {
            align-self: flex-start;
            padding: 10px 20px;
            background-color: #3182ce;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 1.1rem;
            margin-top: 10px;
        }

        .card-content a:hover {
            background-color: #2c5282;
        }

        @media (min-width: 768px) {
            .container {
                flex-direction: row;
            }

            .card {
                flex: 1;
                margin: 0 10px;
            }
        }
    </style>
</head>

<body>
    <div class="overlay">
        <div class="container">
            <div class="card">
                <?php if (!empty($imovel['imagem'])) : ?>
                    <img src="uploads/<?php echo htmlspecialchars($imovel['imagem']); ?>" alt="<?php echo htmlspecialchars($imovel['endereco']); ?>">
                <?php else : ?>
                    <div class="h-300 bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-600">Imagem não disponível</span>
                    </div>
                <?php endif; ?>
                <div class="card-content">
                    <h2><?php echo htmlspecialchars($imovel['endereco']); ?></h2>
                    <div class="property-info">
                        <p><strong>Tipo:</strong> <?php echo htmlspecialchars($imovel['cd_tp_imovel']); ?></p>
                        <p><strong>Preço:</strong> R$ <?php echo number_format($imovel['preco'], 2, ',', '.'); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Cidade:</strong> <?php echo htmlspecialchars($imovel['cidade']); ?></p>
                        <p><strong>Bairro:</strong> <?php echo htmlspecialchars($imovel['bairro']); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>CEP:</strong> <?php echo htmlspecialchars($imovel['cep']); ?></p>
                        <p><strong>Número da Casa:</strong> <?php echo htmlspecialchars($imovel['nmr_casa']); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Venda:</strong> <?php echo converterParaSimOuNao(htmlspecialchars($imovel['dsp_venda'])); ?></p>
                        <p><strong>Aluguel:</strong> <?php echo converterParaSimOuNao(htmlspecialchars($imovel['dsp_aluguel'])); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Vagas de Garagem:</strong> <?php echo htmlspecialchars($imovel['nmr_vaga_garagem']); ?></p>
                        <p><strong>Andar:</strong> <?php echo htmlspecialchars($imovel['andar']); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Valor do Condomínio:</strong> R$ <?php echo number_format($imovel['valor_condominio'], 2, ',', '.'); ?></p>
                        <p><strong>Possui Portaria:</strong> <?php echo converterParaSimOuNao(htmlspecialchars($imovel['possui_portaria'])); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Salas de Jantar:</strong> <?php echo htmlspecialchars($imovel['qtd_sala_jantar']); ?></p>
                        <p><strong>Banheiros:</strong> <?php echo htmlspecialchars($imovel['qtd_banheiros']); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Cômodos:</strong> <?php echo htmlspecialchars($imovel['qtd_comodos']); ?></p>
                        <p><strong>Quartos:</strong> <?php echo htmlspecialchars($imovel['qtd_quartos']); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Suítes:</strong> <?php echo htmlspecialchars($imovel['qtd_suites']); ?></p>
                        <p><strong>Salas de Estar:</strong> <?php echo htmlspecialchars($imovel['qtd_sala_estar']); ?></p>
                    </div>
                    <div class="property-info">
                        <p><strong>Área:</strong> <?php echo htmlspecialchars($imovel['area']); ?> m²</p>
                    </div>
                    <a href="pesquisarImovel.php">Voltar</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
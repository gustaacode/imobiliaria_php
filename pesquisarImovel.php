<?php
// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Configurações da conexão com o banco de dados (substitua pelas suas configurações)
    require_once 'conexao.php';

    // Cria uma instância da classe Database
    $db = new Database();
    $pdo = $db->getConnection();

    // Inicializa a query SQL base
    $sql = "SELECT * FROM imovel WHERE 1=1";

    // Array para armazenar os valores dos parâmetros da consulta
    $params = array();

    // Verifica se foi selecionada uma finalidade
    if (!empty($_POST['finalidade'])) {
        $finalidade = $_POST['finalidade'];
        $sql .= " AND (dsp_venda = :finalidade OR dsp_aluguel = :finalidade)";
        $params[':finalidade'] = $finalidade;
    }

    // Verifica se foi selecionado um tipo de imóvel
    if (!empty($_POST['cd_tp_imovel'])) {
        $cd_tp_imovel = $_POST['cd_tp_imovel'];
        $sql .= " AND cd_tp_imovel = :cd_tp_imovel";
        $params[':cd_tp_imovel'] = $cd_tp_imovel;
    }

    // Verifica se foi digitada uma localização
    if (!empty($_POST['cidade'])) {
        $cidade = $_POST['cidade'];
        // Supondo que o campo 'endereco' no banco de dados contém a localização
        $sql .= " AND (endereco LIKE :cidade OR cidade LIKE :cidade OR bairro LIKE :cidade)";
        $params[':cidade'] = '%' . $cidade . '%'; // Adiciona wildcards para busca parcial
    }

    // Verifica se foi digitado um preço máximo
    if (!empty($_POST['preco'])) {
        $preco = $_POST['preco'];
        $sql .= " AND preco <= :preco";
        $params[':preco'] = $preco;
    }

    // Prepara e executa a consulta
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao executar consulta: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Pesquisa de Imóveis</title>
    <!-- Adicione seus estilos CSS aqui -->
</head>

<body>
    <section class="relative bg-cover bg-center h-96" style="background-image: url('img/banner-front-page.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-25 flex items-center justify-center">
            <div class="container mx-10 p-6 bg-white bg-opacity-75 rounded-lg">
                <form class="grid grid-cols-1 md:grid-cols-3 gap-4" method="POST" action="pesquisarImovel.php">
                    <div>
                        <label for="finalidade" class="block text-gray-700">Finalidade</label>
                        <select id="finalidade" name="finalidade" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">Selecione</option>
                            <option value="S">Compra</option>
                            <option value="N">Locação</option>
                        </select>
                    </div>
                    <div>
                        <label for="property-type" class="block text-gray-700">Tipo de Imóvel</label>
                        <select id="property-type" name="cd_tp_imovel" class="w-full p-2 border border-gray-300 rounded">
                            <option value="">Selecione</option>
                            <option value="2">Casa</option>
                            <option value="1">Apartamento</option>
                            <option value="3">Sala Comercial</option>
                        </select>
                    </div>
                    <div>
                        <label for="cidade" class="block text-gray-700">Cidade</label>
                        <input type="text" id="cidade" name="cidade" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div>
                        <label for="preco" class="block text-gray-700">Preço Máximo</label>
                        <input type="number" id="preco" name="preco" class="w-full p-2 border border-gray-300 rounded">
                    </div>
                    <div class="md:col-span-3 text-center">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Pesquisar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Exibição dos resultados da pesquisa -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($resultados)) : ?>
        <h2 class="text-2xl font-bold mb-4 text-center">Resultados da Pesquisa</h2>
        <div class="container mx-auto my-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php foreach ($resultados as $imovel) : ?>
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    <?php if (!empty($imovel['imagem'])) : ?>
                        <img src="uploads/<?php echo htmlspecialchars($imovel['imagem']); ?>" alt="<?php echo htmlspecialchars($imovel['endereco']); ?>" class="w-full h-60 object-cover object-center">
                    <?php endif; ?>
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2"><?php echo htmlspecialchars($imovel['endereco']); ?></h3>
                        <p><strong>Tipo:</strong> <?php echo htmlspecialchars($imovel['cd_tp_imovel']); ?></p>
                        <p><strong>Preço:</strong> R$ <?php echo number_format($imovel['preco'], 2, ',', '.'); ?></p>
                        <p><strong>Cidade:</strong> <?php echo htmlspecialchars($imovel['cidade']); ?></p>
                        <p><strong>Bairro:</strong> <?php echo htmlspecialchars($imovel['bairro']); ?></p>
                        <a href="detalhesImovel.php?cd_imovel=<?php echo $imovel['cd_imovel']; ?>" class="mt-4 inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Ver Detalhes</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($resultados)) : ?>
        <p class="text-lg text-center">Nenhum imóvel encontrado com os critérios informados.</p>
    <?php endif; ?>
</body>

</html>
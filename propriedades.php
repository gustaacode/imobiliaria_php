<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>Propriedades à Venda - G&A Imobiliária</title>
</head>

<body class="bg-gray-100">
    <!-- Header -->
    <header class="p-none">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.html">
                <img src="img/logo_imobiliaria.png" alt="Logo G&A Imobiliária" class="h-40">
            </a>
            <nav>
                <ul class="flex space-x-4 text-xl font-semibold space-x-11 mr-7">
                    <li><a href="index.php" class="text-blue-900 hover:text-yellow-500">Home</a></li>
                    <li><a href="propriedades.php" class="text-blue-900 hover:text-yellow-500">Propriedades</a></li>
                    <li><a href="index.php#anunciar-prop" class="text-blue-900 hover:text-yellow-500">Anunciar</a></li>
                    <li><a href="servicos.html" class="text-blue-900 hover:text-yellow-500">Serviços</a></li>
                    <li><a href="contato.html" class="text-blue-900 hover:text-yellow-500">Contato</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto mt-6 p-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Propriedades à Venda</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            // Configurações do Banco de Dados
            $hostname = 'localhost';
            $username = 'root';
            $password = '';
            $database = 'imobiliaria';

            // Conectar ao Banco de Dados
            $conn = new mysqli($hostname, $username, $password, $database);

            // Verificar conexão
            if ($conn->connect_error) {
                die("Erro na conexão com o banco de dados: " . $conn->connect_error);
            }

            // Query para selecionar imóveis
            $sql = "SELECT cd_imovel, descricao, imagem FROM imovel";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Exibir imóveis encontrados
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="bg-white shadow-lg rounded-lg overflow-hidden">';
                    echo '<a href="exibir_prop.php?cd_imovel=' . $row['cd_imovel'] . '">';
                    echo '<img class="w-full h-48 object-cover" src="uploads/' . $row['imagem'] . '" alt="' . $row['descricao'] . '">';
                    echo '</a>';
                    echo '<div class="p-4">';
                    echo '<h3 class="text-xl font-bold text-gray-800">' . $row['descricao'] . '</h3>';
                    echo '<p class="text-gray-600 mt-2">' . $row['descricao'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "Nenhum imóvel encontrado.";
            }
            $conn->close();
            ?>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 py-6">
        <div class="container mx-auto text-center text-white">
            <p>&copy; 2023 G&A Imobiliária. Todos os direitos reservados.</p>
        </div>
    </footer>
</body>

</html>
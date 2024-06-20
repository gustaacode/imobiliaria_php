<?php
// Verificar se o parâmetro cd_imovel está presente na URL
if (isset($_GET['cd_imovel'])) {
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

    // Prevenir injeção SQL escapando o parâmetro cd_imovel
    $cd_imovel = $conn->real_escape_string($_GET['cd_imovel']);

    // Query para selecionar o imóvel específico
    $sql = "SELECT cep, cidade, bairro, endereco, nmr_casa, descricao, dsp_venda, dsp_aluguel, preco, 
                   nmr_vaga_garagem, andar, valor_condominio, possui_portaria, qtd_sala_jantar, qtd_banheiros, 
                   qtd_comodos, qtd_quartos, qtd_suites, qtd_sala_estar, area, imagem 
            FROM imovel WHERE cd_imovel = '$cd_imovel'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Exibir informações detalhadas do imóvel
        $row = $result->fetch_assoc();

        // Função para exibir 'Sim' ou 'Não' baseado no valor 'S' ou 'N'
        function sim_nao($valor) {
            return $valor == 'S' ? 'Sim' : 'Não';
        }

        echo '<!DOCTYPE html>';
        echo '<html lang="pt-BR">';
        echo '<head>';
        echo '<meta charset="UTF-8">';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">';
        echo '<title>Detalhes do Imóvel - G&A Imobiliária</title>';
        echo '<style>';
        echo 'body {';
        echo '    margin: 0;';
        echo '    padding: 0;';
        echo '    display: flex;';
        echo '    flex-direction: column;';
        echo '    min-height: 100vh; /* Define a altura mínima da página */';
        echo '}';
        echo '.header, .footer {';
        echo '    background-color: #f59e0b; /* Background amarelo */';
        echo '    color: #fff; /* Cor do texto */';
        echo '    padding: 10px; /* Espaçamento interno */';
        echo '}';
        echo '.main-content {';
        echo '    flex: 1; /* Ocupa todo o espaço restante */';
        echo '    display: flex;';
        echo '    justify-content: center; /* Centraliza o conteúdo horizontalmente */';
        echo '    align-items: center; /* Centraliza o conteúdo verticalmente */';
        echo '    background-color: #edf2f7; /* Fundo cinza claro */';
        echo '}';
        echo '.property-details {';
        echo '    width: 100%;';
        echo '    max-width: 800px; /* Define a largura máxima do detalhe do imóvel */';
        echo '    background-color: #fff; /* Fundo branco */';
        echo '    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra suave */';
        echo '    border-radius: 8px; /* Cantos arredondados */';
        echo '    overflow: hidden; /* Esconde qualquer conteúdo que ultrapasse o contêiner */';
        echo '    margin: 20px; /* Margem externa para separar do conteúdo ao redor */';
        echo '}';
        echo '.property-content {';
        echo '    padding: 20px; /* Espaçamento interno */';
        echo '}';
        echo '.property-image {';
        echo '    width: 100%;';
        echo '    height: 400px; /* Altura da imagem */';
        echo '    object-fit: cover; /* Ajusta a imagem para cobrir todo o espaço */';
        echo '}';
        echo '</style>';
        echo '</head>';
        echo '<body class="bg-gray-100">';
        echo '<div class="header">';
        echo '<div class="container mx-auto flex justify-between items-center">';
        echo '<a href="index.html">';
        echo '<img src="img/logo_imobiliaria.png" alt="Logo G&A Imobiliária" class="h-40">';
        echo '</a>';
        echo '<nav>';
        echo '<ul class="flex space-x-4 text-xl font-semibold space-x-11 mr-7">';
        echo '<li><a href="index.php" class="text-blue-900 hover:text-yellow-500">Home</a></li>';
        echo '<li><a href="propriedades.php" class="text-blue-900 hover:text-yellow-500">Propriedades</a></li>';
        echo '<li><a href="index.php#anunciar-prop" class="text-blue-900 hover:text-yellow-500">Anunciar</a></li>';
        echo '<li><a href="servicos.html" class="text-blue-900 hover:text-yellow-500">Serviços</a></li>';
        echo '<li><a href="contato.html" class="text-blue-900 hover:text-yellow-500">Contato</a></li>';
        echo '</ul>';
        echo '</nav>';
        echo '</div>';
        echo '</div>';
        echo '<div class="main-content">';
        echo '<div class="container mx-auto mt-6">';
        echo '<div class="property-details bg-white shadow-lg rounded-lg">';
        echo '<img class="property-image" src="uploads/' . $row['imagem'] . '" alt="' . $row['descricao'] . '">';
        echo '<div class="property-content p-4">';
        echo '<h2 class="text-2xl font-bold text-gray-800 mb-4">' . $row['descricao'] . '</h2>';
        echo '<p><strong>Endereço:</strong> ' . $row['endereco'] . ', ' . $row['nmr_casa'] . '</p>';
        echo '<p><strong>Bairro:</strong> ' . $row['bairro'] . '</p>';
        echo '<p><strong>Cidade:</strong> ' . $row['cidade'] . ' - CEP: ' . $row['cep'] . '</p>';
        echo '<p><strong>À venda:</strong> ' . sim_nao($row['dsp_venda']) . '</p>';
        echo '<p><strong>Para alugar:</strong> ' . sim_nao($row['dsp_aluguel']) . '</p>';
        echo '<p><strong>Preço:</strong> R$ ' . number_format($row['preco'], 2, ',', '.') . '</p>';
        echo '<p><strong>Vagas na garagem:</strong> ' . $row['nmr_vaga_garagem'] . '</p>';
        echo '<p><strong>Andar:</strong> ' . $row['andar'] . '</p>';
        echo '<p><strong>Valor do condomínio:</strong> R$ ' . number_format($row['valor_condominio'], 2, ',', '.') . '</p>';
        echo '<p><strong>Possui portaria:</strong> ' . ($row['possui_portaria'] ? 'Sim' : 'Não') . '</p>';
        echo '<p><strong>Sala de jantar:</strong> ' . $row['qtd_sala_jantar'] . '</p>';
        echo '<p><strong>Banheiros:</strong> ' . $row['qtd_banheiros'] . '</p>';
        echo '<p><strong>Comodos:</strong> ' . $row['qtd_comodos'] . '</p>';
        echo '<p><strong>Quartos:</strong> ' . $row['qtd_quartos'] . '</p>';
        echo '<p><strong>Suites:</strong> ' . $row['qtd_suites'] . '</p>';
        echo '<p><strong>Sala de estar:</strong> ' . $row['qtd_sala_estar'] . '</p>';
        echo '<p><strong>Área:</strong> ' . $row['area'] . ' m²</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
        echo '<div class="footer">';
        echo '<div class="container mx-auto text-center">';
        echo '<p>&copy; 2023 G&A Imobiliária. Todos os direitos reservados.</p>';
        echo '</div>';
        echo '</div>';
        echo '</body>';
        echo '</html>';

    } else {
        echo "Nenhum imóvel encontrado.";
    }

    // Fechar conexão com o Banco de Dados
    $conn->close();
} else {
    echo "ID do imóvel não especificado.";
}
?>

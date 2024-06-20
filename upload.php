<?php
require_once 'conexao.php';

// Cria uma instância da classe Database
$db = new Database();
$pdo = $db->getConnection();

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Caminho para o diretório onde os uploads serão salvos
    $target_dir = "uploads/";

    // Caminho completo do arquivo de destino
    $target_file = $target_dir . basename($_FILES["imagem"]["name"]);

    // Flag para controle do upload
    $uploadOk = 1;

    // Obtém a extensão do arquivo
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Verifica se o arquivo é uma imagem real
    $check = getimagesize($_FILES["imagem"]["tmp_name"]);
    if ($check === false) {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Verifica se o arquivo já existe
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Verifica o tamanho do arquivo
    if ($_FILES["imagem"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Permite apenas certos formatos de arquivo
    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Verifica se $uploadOk é 0 por causa de um erro
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["imagem"]["name"])) . " has been uploaded successfully.";

            // Obtém os valores do formulário
            $cd_tp_imovel = $_POST['cd_tp_imovel'];
            $endereco = $_POST['endereco'];
            $cidade = $_POST['cidade'];
            $bairro = $_POST['bairro'];
            $cep = $_POST['cep'];
            $nmr_casa = $_POST['nmr_casa'];
            $dsp_venda = $_POST['dsp_venda'];
            $dsp_aluguel = $_POST['dsp_aluguel'];
            $preco = $_POST['preco'];
            $nmr_vaga_garagem = $_POST['nmr_vaga_garagem'];
            $descricao = $_POST['descricao'];
            $andar = $_POST['andar'];
            $valor_condominio = $_POST['valor_condominio'];
            $possui_portaria = $_POST['possui_portaria'];
            $qtd_sala_jantar = $_POST['qtd_sala_jantar'];
            $qtd_banheiros = $_POST['qtd_banheiros'];
            $qtd_comodos = $_POST['qtd_comodos'];
            $qtd_quartos = $_POST['qtd_quartos'];
            $qtd_suites = $_POST['qtd_suites'];
            $qtd_sala_estar = $_POST['qtd_sala_estar'];
            $area = $_POST['area'];
            $imagem_caminho = $target_file;

            // Insere os dados no banco de dados
            $sql = "INSERT INTO imovel (cd_tp_imovel, endereco, cidade, bairro, cep, nmr_casa, dsp_venda, dsp_aluguel, preco, nmr_vaga_garagem, descricao, andar, valor_condominio, possui_portaria, qtd_sala_jantar, qtd_banheiros, qtd_comodos, qtd_quartos, qtd_suites, qtd_sala_estar, area, imagem)
            VALUES (:cd_tp_imovel, :endereco, :cidade, :bairro, :cep, :nmr_casa, :dsp_venda, :dsp_aluguel, :preco, :nmr_vaga_garagem, :descricao, :andar, :valor_condominio, :possui_portaria, :qtd_sala_jantar, :qtd_banheiros, :qtd_comodos, :qtd_quartos, :qtd_suites, :qtd_sala_estar, :area, :imagem)";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':cd_tp_imovel', $cd_tp_imovel);
            $stmt->bindParam(':endereco', $endereco);
            $stmt->bindParam(':cidade', $cidade);
            $stmt->bindParam(':bairro', $bairro);
            $stmt->bindParam(':cep', $cep);
            $stmt->bindParam(':nmr_casa', $nmr_casa);
            $stmt->bindParam(':dsp_venda', $dsp_venda);
            $stmt->bindParam(':dsp_aluguel', $dsp_aluguel);
            $stmt->bindParam(':preco', $preco);
            $stmt->bindParam(':nmr_vaga_garagem', $nmr_vaga_garagem);
            $stmt->bindParam(':descricao', $descricao);
            $stmt->bindParam(':andar', $andar);
            $stmt->bindParam(':valor_condominio', $valor_condominio);
            $stmt->bindParam(':possui_portaria', $possui_portaria);
            $stmt->bindParam(':qtd_sala_jantar', $qtd_sala_jantar);
            $stmt->bindParam(':qtd_banheiros', $qtd_banheiros);
            $stmt->bindParam(':qtd_comodos', $qtd_comodos);
            $stmt->bindParam(':qtd_quartos', $qtd_quartos);
            $stmt->bindParam(':qtd_suites', $qtd_suites);
            $stmt->bindParam(':qtd_sala_estar', $qtd_sala_estar);
            $stmt->bindParam(':area', $area);
            $stmt->bindParam(':imagem', $imagem_caminho);

            if ($stmt->execute()) {
                echo "Imóvel cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar imóvel: " . $stmt->errorInfo()[2];
            }
        } else {
            echo "Erro ao fazer upload da imagem.";
        }
    }
}
?>

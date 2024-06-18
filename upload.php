<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    // Tenta fazer o upload do arquivo
    } else {
        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
            echo "The file ". htmlspecialchars(basename($_FILES["imagem"]["name"])). " has been uploaded successfully.";

            // Dados do formulário
            $nmr_casa = $_POST['nmr_casa'];
            $cd_bairro = $_POST['cd_bairro'];
            $endereco = $_POST['endereco'];
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
            $imagem = basename($_FILES["imagem"]["name"]);

            // Configurações de conexão ao banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "imobiliaria";

            // Cria a conexão
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verifica a conexão
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Prepara e vincula os parâmetros
            $stmt = $conn->prepare("INSERT INTO imovel (cd_bairro, endereco .', '.,, dsp_venda, dsp_aluguel, preco, nmr_vaga_garagem, descricao, andar, valor_condominio, possui_portaria, qtd_sala_jantar, qtd_banheiros, qtd_comodos, qtd_quartos, qtd_suites, qtd_sala_estar, area, imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssisssisiiiiiis", $cd_bairro, $endereco, $nmr_casa, $dsp_venda, $dsp_aluguel, $preco, $nmr_vaga_garagem, $descricao, $andar, $valor_condominio, $possui_portaria, $qtd_sala_jantar, $qtd_banheiros, $qtd_comodos, $qtd_quartos, $qtd_suites, $qtd_sala_estar, $area, $imagem);

            // Executa a declaração
            if ($stmt->execute()) {
                echo "New record created successfully.";
            } else {
                echo "Error: " . $stmt->error;
            }

            // Fecha a declaração e a conexão
            $stmt->close();
            $conn->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
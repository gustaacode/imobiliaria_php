<?php
// Inclui a definição da classe Database
require_once 'conexao.php';

// Cria uma instância da classe Database
$db = new Database();
$conn = $db->getConnection(); // Obtém a conexão PDO

// Verifica se a conexão foi estabelecida corretamente
if ($conn === null) {
    die("Erro ao conectar ao banco de dados");
}

class ViaCEP
{
    private $base_url = "https://viacep.com.br/ws/";

    public function consultarCEP($cep)
    {
        $url = $this->base_url . urlencode($cep) . "/json/";

        // Inicia uma sessão cURL
        $ch = curl_init($url);

        // Configura as opções da sessão cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Executa a requisição
        $response = curl_exec($ch);

        // Verifica por erros na requisição
        if (curl_errno($ch)) {
            throw new Exception('Erro ao realizar requisição: ' . curl_error($ch));
        }

        // Fecha a sessão cURL
        curl_close($ch);

        // Decodifica a resposta JSON
        $data = json_decode($response, true);

        // Verifica se o CEP foi encontrado
        if (!empty($data) && !isset($data['erro'])) {
            return $data;
        } else {
            return null;
        }
    }
}



<?php

class Database {
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "imobiliaria";
    private $conn;

    // Método para estabelecer a conexão
    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
            // Configura o PDO para lançar exceções em caso de erros
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    // Método para obter a conexão PDO
    public function getConnection() {
        return $this->conn;
    }

    // Método para fechar a conexão ao finalizar o objeto
    public function __destruct() {
        $this->conn = null;
    }
}

?>

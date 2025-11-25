<?php
require_once 'config.php';

class conexao {
    private static $pdo;

    private function __construct() {}

    private static function verificaExtensao() {
        if (!extension_loaded('pdo_mysql')) {
            throw new Exception('A extensão pdo_mysql não está habilitada.');
        }
    }

    public static function getInstance() {
        self::verificaExtensao();

        if (!isset(self::$pdo)) {
            try {
                // Configuração de conexão com o MySQL
                self::$pdo = new PDO(
                    'mysql:host=' . HOST . ';port=' . PORT . ';dbname=' . DBNAME . ';charset=' . CHARSET,
                    USER,
                    PASSWORD
                );
                // Configuração adicional: lança exceções em caso de erro
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                print "Erro: " . $e->getMessage();
            }
        }
        return self::$pdo;
    }

    public static function isConectado() {
        return isset(self::$pdo);
    }
}


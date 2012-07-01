<?php
/**
 * Classe Conexao para banco utilizando singleton
 */
class Conexao extends PDO {

    private static $instance;

    private function Conexao($dados_conn) {
        return parent::__construct($dados_conn->getProperty("dns"), $dados_conn->getProperty("usuario"), $dados_conn->getProperty("senha"));
    }

    public static function getInstance($dados_conn) {
        if (empty(self::$instance))
            self::$instance = new Conexao($dados_conn);

        return self::$instance;
    }

}

?>
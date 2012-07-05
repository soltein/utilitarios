<?php

/**
 * @author Julio Cezar <julio at soltein.com.br>
 */

class CRUD{

    private $table = "";
    private $insert = "";
    private $select = "";
    private $update = "";
    private $delete = "";
    private $conexao = "";

    public function __construct($table, $conexao) {
        $this->table = $table;
        $this->conexao = $conexao;
    }

    public function insert($campos, $valores) {
        $this->insert = "INSERT INTO " . $this->table . " (" . $campos . ") VALUES (" . $valores . ")";
        $this->conexao->exec($this->insert);
    }

    public function update($campos_valores, $where = null) {
        if ($where) {
            $this->update = "UPDATE " . $this->table . " SET " . $campos_valores . " WHERE " . $where;
        } else {
            $this->update = "UPDATE " . $this->table . " SET " . $campos_valores;
        }

        $this->conexao->exec($this->update);
    }

    public function del($where = null) {
        if ($where) {
            $this->delete = "DELETE FROM " . $this->table . " WHERE " . $where;
        } else {
            $this->delete = "DELETE FROM " . $this->table;
        }

        $this->conexao->exec($this->delete);
    }

    public function all($opcoes = null) {
        $this->select = "SELECT ";

        if (!empty($opcoes["select"])) {
            $this->select .= $opcoes["select"];
        } else {
            $this->select .= " * ";
        }

        $this->select .= " FROM " . $this->table;

        if (!empty($opcoes["joins"])) {
            $this->select .= $opcoes["joins"];
        }

        if (!empty($opcoes["conditions"])) {
            $this->select .= " WHERE " . $opcoes["conditions"];
        }
        
        

        $rs = $this->conexao->prepare($this->select);

        $rs->execute();

        return($rs->fetchAll());
    }

}

?>

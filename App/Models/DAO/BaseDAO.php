<?php

namespace App\Models\DAO;

use App\Lib\Conexao;

abstract class BaseDAO
{
    protected $conexao;

    public function __construct()
    {
        $this->conexao = Conexao::getConnection();
    }

    public function select($sql, $params = [])
    {
        if (!empty($sql)) {
            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($params);
            return $stmt;
        }
        return false;
    }

    public function insert($table, $cols, $values)
    {
        if (!empty($table) && is_array($cols) && is_array($values)) {
            $colunas = implode(', ', array_keys($cols));
            $parametros = implode(', ', array_keys($values));

            $stmt = $this->conexao->prepare("INSERT INTO $table ($colunas) VALUES ($parametros)");

            foreach ($values as $key => &$value) {
                $stmt->bindParam($key, $value);
            }

            $stmt->execute();

            return $stmt->rowCount();
        } else {
            return false;
        }
    }

    public function update($table, $cols, $values, $where = null)
    {
        if (!empty($table) && is_array($cols) && is_array($values)) {
            if ($where) {
                $where = " WHERE $where ";
            }

            $setCols = [];
            foreach ($cols as $col => $param) {
                $setCols[] = "$col = $param";
            }
            $setCols = implode(", ", $setCols);

            $stmt = $this->conexao->prepare("UPDATE $table SET $setCols $where");
            $stmt->execute($values);

            return $stmt->rowCount();
        } else {
            return false;
        }
    }

    public function delete($table, $where = null, $params = [])
{
    try {
        if (!empty($table)) {
            $sql = "DELETE FROM $table";
            if ($where) {
                $sql .= " WHERE $where";
            }

            $stmt = $this->conexao->prepare($sql);
            $stmt->execute($params);

            return $stmt->rowCount();
        } else {
            return false;
        }
    } catch (\PDOException $e) {
        // Captura e relança a exceção PDOException
        throw $e;
    } catch (\Exception $e) {
        // Captura e relança exceções genéricas
        throw $e;
    }
}

}

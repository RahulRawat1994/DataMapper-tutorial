<?php

namespace Database;

class PdoAdapter implements DatabaseAdapterInterface
{
    private $_conn;
    private $_connectionString;
    private $_user;
    private $_pass;
    private $_options;

    public function __construct(String $connectionString, String $user, String $pass, $options = null)
    {
        $this->_connectionString = $connectionString;
        $this->_user    = $user;
        $this->_pass    = $pass;
        $this->_options = $options;
    }

    /**
     * Open the database connection
     */
    public function openConnection()
    {
        try {
            $this->_conn = new \PDO($this->_connectionString, $this->_user, $this->_pass, $this->_options);
        } catch (\PDOException $e) {
            throw new Exception("Unable to connect with database <br/>".$e->getMessage(), $e->getCode());
        }
    }

    public function select(string $table, array $whr = null, array $fields = null)
    {
        $attributes='';
        if (is_null($fields)) {
            $attributes='*';
        } else {
            $attributes = implode(",", array_values($fields));
        }

        $conditions='';
        if (!is_null($whr)) {
            foreach ($whr as $key => $value) {
                $conditions.="$key ='$value'";
                if (next($fields)) {
                    $conditions.=' and ';
                }
            }
        }

        $sql = "SELECT $attributes FROM {$table}";
        if ($conditions != '') {
            $sql .= " WHERE $conditions";
        }
        $this->_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {
            $stmt =  $this->_conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function insert(string $table, array $fields)
    {
        $attributes = implode(",", array_keys($fields));
        $values = "'".implode("','", array_values($fields)) ."'";
        $sql ="INSERT INTO {$table} ($attributes) VALUES ($values)";
        $this->_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {
            $stmt = $this->_conn->prepare($sql);
            $stmt->execute();
            return $this->_conn->lastInsertId();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function update(string $table, array $fields, array $whr)
    {
        $attributes='';
        foreach ($fields as $field => $value) {
            $attributes.="$field='$value'";
            if (next($fields)) {
                $attributes.=' , ';
            }
        }

        $conditions='';
        foreach ($whr as $key => $value) {
            $conditions.="$key ='$value'";
            if (next($fields)) {
                $conditions.=' and ';
            }
        }

        $sql = "UPDATE {$table} SET $attributes WHERE $conditions";
        $this->_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {
            $stmt = $this->_conn->prepare($sql);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function delete(string $table, int $id)
    {
        $sql = "DELETE FROM {$table} WHERE id={$id}";
        $this->_conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        try {
            $stmt = $this->_conn->prepare($sql);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function __destruct()
    {
        $this->_conn = null;
    }
}

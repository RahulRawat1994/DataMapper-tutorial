<?php

namespace DMDatabase;

class PdoAdapter implements DatabaseAdapterInterface{

    private $_conn;
    private $_connectionString;
    private $_user;
    private $_pass;
    private $_options;
    private $_statement;

    public function __construct(String $connectionString, String $user, String $pass, $options = NULL ){
        
        $this->_connectionString = $connectionString;
        $this->_user    = $user;
        $this->_pass    = $pass;
        $this->_options = $options;

        $this->_conn = $this->_openConnection();
    
    }

    /**
     * Open the database connection
     */
    private function _openConnection(){
        try {
            $this->_conn = new PDO($this->_connectionString, $this->_user, $this->_pass, $this->_options);
        } catch (\PDOException $e) {
           
        }
    }

    public function select($table, $whr = NULL, $fields = NULL){
        try{
            $sql = "SELECT * FROM {$table}";
            $this->_statement =  $this->_conn->prepare($sql);
            $this->_statement ->execute();
        } catch(\PDOException $e){

        }
    }

    public function fetch(){
        try{
            return $this->_statement->fetchAll(\PDO::FETCH_ASSOC);
        }catch(\PDOException $e){

        }
    }

    public function insert($table, $fields){

        $stmt = $this->_conn->prepare("INSERT INTO {$table} (firstname, lastname, email) 
        VALUES ('Hello','world','hello@world')");
        $stmt = $this->_conn->prepare($sql);
        $stmt->execute();

    }

    public function update($table, $fields, $whr){
        try{
            $sql = "UPDATE {$table} SET lastname='Doe' WHERE id=2";
            $stmt = $this->_conn->prepare($sql);
            $stmt->execute();
        } catch(\PDOException $e){

        }
    }

    public function delete($table, $id){
        try{
            $sql = "DELETE FROM {$table} WHERE id={$id}";
            $this->_conn->exec($sql);
        } catch(\PDOException $e){
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function __destruct(){
        $this->_conn = null;
    }
}
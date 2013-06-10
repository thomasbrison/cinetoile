<?php

require ("connexion.php");

abstract class Table {
    
    private $_name;
    private $_primary_key;
   
    protected function __construct($name,$primary_key) {
        $this->_name=$name;
        $this->_primary_key=$primary_key;
        defined('connect') || connexion_bd();
    }
    
    public function getAll(){
        $query = "SELECT * FROM $this->_name;";
        return mysql_query($query);
    }
    
    public function getAttributes($key){
        $query = "SELECT * FROM $this->_name WHERE $this->_primary_key = '$key';";
        $result=mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }
    
    abstract function consult();
    
    public function remove($key){
        $query = "DELETE FROM $this->_name WHERE $this->_primary_key = '$key';";
        mysql_query($query);
    }
}
?>

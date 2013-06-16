<?php

require ("connexion.php");

abstract class Table {

    private $name;
    private $primaryKey;

    protected function __construct($name, $primaryKey) {
        $this->name = $name;
        $this->primaryKey = $primaryKey;
        defined('connect') || connexion_bd();
    }

    public function getAll() {
        $query = "SELECT * FROM $this->name;";
        return mysql_query($query);
    }

    public function getAttributes($key) {
        $query = "SELECT * FROM $this->name WHERE $this->primaryKey = '$key';";
        $result = mysql_query($query);
        $row = mysql_fetch_assoc($result);
        return $row;
    }

    abstract function consult();

    public function remove($key) {
        $query = "DELETE FROM $this->name WHERE $this->primaryKey = '$key';";
        mysql_query($query);
    }

}

?>

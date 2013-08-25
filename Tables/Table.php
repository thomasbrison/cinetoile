<?php

require_once 'Lib/connexion.php';

abstract class Table {

    protected $dbh;
    private $name;
    private $primaryKey;

    protected function __construct($name, $primaryKey) {
        $this->name = $name;
        $this->primaryKey = $primaryKey;
        defined('connect') || ($this->dbh = connexion_bd());
    }

    public function getAll() {
        $query = "SELECT * FROM $this->name;";
        $sth = $this->dbh->query($query);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Returns an array with the values of the column
     * @param String $column Name of the column
     */
    public function getColumn($column) {
        $query = "SELECT $column FROM $this->name;";
        $sth = $this->dbh->query($query);
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAttributes($key) {
        $query = "SELECT * FROM $this->name WHERE $this->primaryKey = '$key';";
        $sth = $this->dbh->query($query);
        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    abstract function consult();

    public function remove($key) {
        $query = "DELETE FROM $this->name WHERE $this->primaryKey = '$key';";
        $this->dbh->query($query);
    }

}

?>

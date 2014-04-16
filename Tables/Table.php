<?php

require_once 'Lib/connexion.php';

/**
 * Abstract class for tables in the database
 *
 * @author thomas.brison@grenoble-inp.org
 */
abstract class Table {

    /**
     * @var PDO
     */
    protected $dbh;

    /**
     *
     * @var string Table name
     */
    protected $name;

    /**
     *
     * @var mixed Name of primary key
     */
    protected $primaryKey;

    /**
     * Connect to the database and defines the table name and the primary key of this table.
     * @param type $name
     * @param type $primaryKey
     */
    protected function __construct($name, $primaryKey) {
        $this->name = $name;
        $this->primaryKey = $primaryKey;
        defined('connect') || ($this->dbh = connexion_bd());
    }

    /**
     * Select all from a database.
     * @return array An associative array containing the results by row
     */
    public function getAll() {
        $query = "SELECT * FROM $this->name;";
        $sth = $this->dbh->query($query);
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return an array with the values of the column.
     * @param String $column Name of the column
     */
    public function getColumn($column) {
        $query = "SELECT $column FROM $this->name;";
        $sth = $this->dbh->query($query);
        return $sth->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Select a row in the table.
     * @param mixed $key The primary key of the entry
     * @return array A bean containing the results of the row
     */
    public function getAttributes($key) {
        $query = "SELECT * FROM $this->name WHERE $this->primaryKey = :key;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':key', $key);
        if ($sth->execute()) {
            return $sth->fetch(PDO::FETCH_ASSOC);
        }
        return NULL;
    }

    /**
     * Function to consult the elements in the table.
     * Should return an array of beans.
     */
    abstract function consult();

    /**
     * Add an entry in the database.
     */
    abstract function add($object);

    /**
     * Update an entry in the database.
     */
    abstract function update($object);

    /**
     * Remove an entry in the database.
     * @param mixed $key The primary key of the entry
     * @return Number of rows affected
     */
    public function remove($key) {
        $query = "DELETE FROM $this->name WHERE $this->primaryKey = :key;";
        $sth = $this->dbh->prepare($query);
        $sth->bindParam(':key', $key);
        return $sth->execute();
    }

}

?>

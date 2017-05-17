<?php

class Database extends PDO {

    private $totalRows;
    private $columns;

    function __construct() {
//        echo "hola";
        try {
            parent::__construct(DB_ROUTE, DB_USER, DB_PASSWORD, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
        } catch (PDOException $e) {
            var_dump($e);
        }
    }

    function selectQuery($table, $columns, $where = "", $status = "") {
//        var_dump(explode(' ',trim($table)));
//        $status=explode(' ',trim($table))[0].".$status";

        if ($status == "") {
 
//            $where = trim($where) == "" ? " " : " WHERE $where AND $status";
            $where = trim($where) == "" ? " " : " WHERE $where ";
        } else {
//            $where = trim($where) == "" ? " WHERE $status " : " WHERE $where AND $status";
            $where = trim($where) == "" ? " WHERE $status " : " WHERE $where ";
        }

        echo "SELECT $columns FROM $table $where";
        return parent::query("SELECT $columns FROM $table $where");
    }

    function insertQuery($table, $columns, $values) {
        $query = parent::query("INSERT INTO $table ($columns) VALUES ($values)");
        echo "INSERT INTO $table ($columns) VALUES ($values)";
        return ($query) ? parent::lastInsertId() : 0;
    }

    function updateQuery($table, $columnValues, $where) {
        return parent::query("UPDATE $table SET $columnValues WHERE $where");
    }

    function query($query) {
        return parent::query($query);
    }

}

<?php
include 'DataBaseEngine/MysqlEngine.php';

class DataBaseRepository {

    static public $database;

    static public function setDataBase(IRepositoryDataBaseCommands $database){
        self::$database = $database;
    }
}
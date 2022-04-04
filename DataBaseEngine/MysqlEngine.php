<?php
include 'Interfaces/IRepositoryDataBaseCommands.php';

class MysqlEngine implements IRepositoryDataBaseCommands {

    static private $mysqli;

    public function __construct(mysqli $mysqli) {
        self::$mysqli = $mysqli;
    }

    /**
     * Выполнение mysqli->query
     * @param string $query Запрос
     */
    public function query(string $query) {
        return self::$mysqli->query($query);
    }

    /**
     * Выполнение sql инъекции
     * @param string $query Выполняемый запрос
     * @param string $types Строка, содержащая один или более символов, каждый из которых задаёт тип значения привязываемой переменной: i - int d - double s - string b - blob
     * @param mixed &$var Аргумент для SQL запроса
     * @param mixed &$vars Перечисление аргументов для SQL запроса
     * @return object Объект-результат mysqli_stmt::get_result
     */
    public function injection(string $query, string $types, &$var, &...$vars) {
        $prepare = self::$mysqli->prepare($query);
        $prepare->bind_param($types,$var,...$vars);
        $prepare->execute();
        return $prepare->get_result();
    }

    public function last_insert_id() {
        return self::$mysqli->insert_id;
    }

    public function last_error() {
        return self::$mysqli->error;
    }
}
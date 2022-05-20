<?php

namespace vendor\core;

class Db
{
    protected $pdo;
    protected static $intance;
    public static $countSql = 0; // количество выполненных запрсов к Бд
    public static $queries = []; // массив в котором будем записывать все наши запросы 


    protected function __construct()
    {
        // $db - предствляет себя как массив из конфигурации базданных
        $db = require ROOT . '/config/config_db.php';

        // показ ошибок 
        $options = [
            // ошибки, произошла ошибка к подключению в БД
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION, //  Выбрасывает PDOException.
            // формат данных по умолчанию
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC // Устанавливает режим выборки по умолчанию
        ];

        // class PDO - Представляет соединение между PHP и сервером базы данных
        // PDO и mysqli. PDO является универсальным DBAL, позволяющим работать с любой поддерживаемой базой.
        $this->pdo = new \PDO($db['dsn'], $db['user'], $db['pass'], $options);
    }

    // проверяет если в обекте ничего нет то будет создан обект  
    public static function instance()
    {
        if (self::$intance === null) {
            self::$intance = new self; // записываем обект
        }
        return self::$intance;
    }

    // true or false выполянеять для тех случаях когда нужно чтобы выполнися sql запрос данные не нужны
    public function execute($sql)
    {
        self::$countSql++;
        self::$queries[]= $sql; // без скобок [] будет записан только 1 запрос 
        // подготовка 
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute();
    }

    // готвоить и исполнять, но еще возвращать данные, SELECT 
    public function query($sql)
    {
        self::$countSql++;
        self::$queries[]= $sql;
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute();
        if ($res !== false) {
            // etchAll — Извлекает оставшиеся строки из результирующего набора
            return $stmt->fetchAll();
        }
        return [];
    }
}

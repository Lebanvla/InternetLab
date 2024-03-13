<?php
class DataBase
{
    private static $instance = null;

    private $connection = null;

    protected function __construct()
    {
        $this->connection = new mysqli("localhost", "root", "", "autochemical");
    }
    protected function __clone()
    {
    }
    public function __wakeup()
    {
        throw new BadFunctionCallException("Запрещена десереализация соединения с базой данных");
    }

    public static function getInstance(): DataBase
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    public static function connection(): mysqli
    {
        return static::getInstance()->connection;
    }
    public static function prepare($statement): mysqli_stmt
    {
        return static::connection()->prepare($statement);
    }

    public static function query($sql)
    {
        return static::connection()->query($sql);
    }


}


?>
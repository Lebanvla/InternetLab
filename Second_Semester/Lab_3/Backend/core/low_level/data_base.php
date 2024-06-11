<?php
    require_once("log.php");
    class DataBaseException extends Exception{}

    class DataBase{

        public static function mysqli_result_to_array(mysqli_result | bool $result) : array | null{
            try{
                $rows= [];
                if(gettype($result)=== "boolean"){
                    return null;
                }
                while($row = mysqli_fetch_assoc($result)){
                    if($row === null){
                        throw new InvalidArgumentException("Non correct parameter");
                    }
                    $rows[] = $row;
                }
                return $rows;
            }
            catch(Exception $e){
                separated_log($e->getMessage());
                throw new DataBaseException("Non correct params");
            }
        }

        private static string $host = "localhost";
        private static string $user_name = "root";
        private static string $database_name = "grass"; 
        private static string $password = "";


        private static $instance = null;
        private $connection = null;


        protected function __construct(){
            try{
            $this->connection = new mysqli(self::$host, self::$user_name, self::$password, self::$database_name, 3306);
            }catch(mysqli_sql_exception $e){
                throw new DataBaseException("Database connection creation error");
            }
        }

        protected function __clone(){}

        public function __wakeup(){
            throw new DataBaseException("Method wakeup not allowed");
        }

        public static function getInstance(): DataBase{
            if(self::$instance === null){
                self::$instance = new static();
            }
            return self::$instance;
        }

        public static function get_connection(): mysqli{
            return static::getInstance()->connection;
        }

        public static function query(string $sql) : array | null{
            try{

                return static::mysqli_result_to_array(static::get_connection()->query($sql));
            }
            catch(mysqli_sql_exception $e){
                add_log(
                    "In database query exception"
                );
                throw new DataBaseException("Database query error");
            }
        }

        public static function prepared_query(string $sql, $types, array $params){
            try{
                $stmt = static::get_connection()->prepare($sql);
                $stmt->bind_param($types, ...$params);
                $stmt->execute();
                $result = self::mysqli_result_to_array($stmt->get_result());
                return $result;
                
            }catch(Exception $e){
                throw new DataBaseException($e->getMessage());
            }
        
        }
    }


?>
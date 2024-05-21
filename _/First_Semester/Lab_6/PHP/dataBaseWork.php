<?php
    
    function logWriter(string $messange){
        $fd = fopen("PHP/log.txt", 'a');
        fwrite($fd, $messange."\n");
        fclose($fd);
    }
    
    class dataBase{
        
        private static $instance;
        
        private $link = null;        
        

        private function __construct(){ 
            $this->link = new mysqli("localhost", "root","","autochemical");
            logWriter("Установлено соединение");
        }


        protected function __clone()    { } 
        
        
        public function __wakeup()   { 
            throw new \BadMethodCallException('Unable deserealise database connection');
        }


        public static function getDataBase() :dataBase{
            if(null === self::$instance){
                self::$instance = new static();
                logWriter("Создали Синглетон");
            }
            logWriter("Обратились к объекту");
            return self::$instance;
        }

        
        public static function getLink() : mysqli{
            logWriter("Обратились к БД");
            return static::getDataBase()->link;
        }


        public static function prepare(string $query){
            logWriter("Подготовили запрос");
            return static::getLink()->prepare($query);
        }
}



    class productTable{
        public static function getAllProducts(){
            $query = dataBase::prepare("select productName, image, brandName, typeName, price, description
                                        from products
                                        join brands on products.chemicalBrand_ID = brands.brand_id
                                        join types on products.chemicalType_ID = types.typeId");
            $query->execute();
            $result = $query->get_result();
            if(!$result){
                throw new mysqli_sql_exception("При выводе всех продуктов произошла ошибка");
            }
            logWriter("Выполнили запрос по получению продуктов");
            $output = array();
            while($row = $result->fetch_assoc()) {
                $output[] = $row;
            }
            return $output;
        }

        public static function getProductsByBrand(string $brand){
            $query = dataBase::prepare("select productName, image, brandName, typeName, price, description
                                        from products
                                        join brands on products.chemicalBrand_ID = brands.brand_id
                                        join types on products.chemicalType_ID = types.typeId
                                        where chemicalBrand_ID = ?");
            
            $query->bind_param("i", $brand);
            $query->execute();
            $result = $query->get_result();
            if(!$result){
                throw new mysqli_sql_exception("При выводе продуктов по id произошла ошибка");
            }
            logWriter("Выполнили запрос по получению продуктов");
            $output = array();
            while($row = $result->fetch_assoc()) {
                $output[] = $row;
            }
            return $output;
        }


        public static function addNewProduct(string $productName, $productPrice, $productImage, $productDescription, $productBrand, $productType){
            $query = dataBase::prepare("SELECT productName, price, image, description, chemicalType_ID, chemicalBrand_ID 
                                        from products where productName = ?");
            $query->bind_param("s", $productName);
            $query->execute();
            $result = $query->get_result();
            if($result->num_rows == 0){
                $query = dataBase::prepare("INSERT into autochemical.products 
                                            (productName, price, image, description, chemicalType_ID, chemicalBrand_ID)
                                            VALUES (?, ?, ?, ?, ?, ?)");
                if(!$query->bind_param("sissii", $productName, $productPrice, $productImage, $productDescription, $productType, $productBrand)){
                    throw new mysqli_sql_exception("При введении параметров произошла ошибка");
                }
                if(!$query->execute()){
                    throw new mysqli_sql_exception("При добавлении продукта произошла ошибка");
                }
            }
            else throw new mysqli_sql_exception("Уже существует такой продукт");
        

    }
}
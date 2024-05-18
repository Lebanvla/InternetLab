<?php
    
    function logWriter(string $messange){
        $fd = fopen($_SERVER['DOCUMENT_ROOT'] . '/InternetLab/Lab_7/' . "PHP/log.txt", 'a');
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

        public static function query(string $query){
            return static::getLink()->query($query);
        }
}



    class productTable{
        public static function getAllProducts(){
            $query = dataBase::prepare("select *
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
            $query = dataBase::prepare("select *
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

        public static function getProductByName(string $name){
            $query = dataBase::prepare("select *
                                        from products
                                        where productName = ?");
            
            $query->bind_param("s", $name);
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
            return array_shift($output);
        }


        public static function addNewProduct(string $productName, int $productPrice, string $productImage, string $productDescription, int $productBrand, int $productType){
            $query = dataBase::prepare("SELECT productName, price, image, description, chemicalType_ID, chemicalBrand_ID 
                                        from products where productName = ?");
            $query->bind_param("s", $productName);
            $query->execute();
            $result = $query->get_result();
            logWriter("Выполнил запрос по получению продукта");
            if($result->num_rows == 0){
                $query = dataBase::query("SELECT MAX(id_product) from products");
                logWriter("Получил макисмальный id продукта");
                $result = $query->fetch_assoc();
                $productID = $result["MAX(id_product)"] + 1;
                logWriter("ID продукта ". $productID." - ". $productID["MAX(id_product)"]);
                $query = dataBase::prepare("INSERT into autochemical.products 
                                            (id_product, productName, price, image, description, chemicalType_ID, chemicalBrand_ID)
                                            VALUES (?, ?, ?, ?, ?, ?, ?)");
                if(!$query->bind_param("isissii", $productID, $productName, $productPrice, $productImage, $productDescription, $productType, $productBrand)){
                    throw new mysqli_sql_exception("При введении параметров произошла ошибка");
                }
                if(!$query->execute()){
                    throw new mysqli_sql_exception("При добавлении продукта произошла ошибка");
                }
            }
            else throw new mysqli_sql_exception("Уже существует такой продукт");
    }


        public static function removeProductByName(string $name){
            $query = dataBase::prepare("select image from products where productName = ?");
            if(!$query->bind_param("s", $name)){
                throw new mysqli_sql_exception("При введении параметров произошла ошибка");
            }
            logWriter("Подготовка параметров 1 закончилась успешно");
            if(!$query->execute()){
                throw new mysqli_sql_exception("При поиске продукта произошла ошибка");
            }
            logWriter("Поиск продукта 1 закончился успешно");
            $imageName = $_SERVER['DOCUMENT_ROOT'] . '/InternetLab/Lab_7/productpicture/' . $query->get_result()->fetch_array()["image"].".png";
            
            if(file_exists($imageName) && !unlink($imageName)){
                throw new mysqli_sql_exception("При удалении картинки произошла ошибка");
            }
            logWriter("Удаление картинки успешно");
            $query = dataBase::prepare("delete from products where productName = ?");
            if(!$query->bind_param("s", $name)){
                throw new mysqli_sql_exception("При введении параметров произошла ошибка");
            }
            logWriter("Подготовка параметров 2 закончилась успешно");
            if(!$query->execute()){
                throw new mysqli_sql_exception("При удалении продукта произошла ошибка");
            }
            logWriter("Удаление продукта успешно");
        }


        public static function changeProductByName(string $productName, string $newProductName, int $newProductPrice, string $newProductImage, string $newProductDescription, int $newProductBrand, int $newProductType){
            $query = dataBase::prepare("select productName, image from products where productName = ?");
            if(!$query->bind_param("s", $productName)){
                throw new mysqli_sql_exception("При 1 введении параметров произошла ошибка");
            }
            if(!$query->execute()){
                throw new mysqli_sql_exception("При поиске продукта произошла ошибка");
            }
            $result = $query->get_result();

            if($result->num_rows == 0){
                throw new mysqli_sql_exception("Такого продукта нет в базе");
            }
            else{
                $query = dataBase::prepare("update products
                                            SET productName=?, price=?, image=?, description=?, chemicalType_ID=?, chemicalBrand_ID=? 
                                            where productName=?");
                $query->bind_param("sissiis", $newProductName, $newProductPrice, $newProductImage, $newProductDescription, $newProductType, $newProductBrand, $productName);
                $query->execute();
            }
        }
}
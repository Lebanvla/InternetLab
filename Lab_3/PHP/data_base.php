<?php
class DataBase{
    private static mysqli $link; 
    private static bool $isConnected = false;
    static function connect(){
        if(self::$isConnected == false){
            self::$link = new mysqli("localhost", "root","","autochemical");
            self::$isConnected = true;
        }
    }
    static function addUser($login, $password, $VK, $interests, $userBloodResus, $userBloodGroup){
        $query = self::$link->prepare("SELECT count(*) as quanity from autochemical.clients where login=?");
        $query->bind_param('s', $login);
        $query->execute();
        if($query->get_result()->fetch_assoc()["quanity"] == 0){ 
            $query = self::$link->prepare("INSERT into clients VALUES(?, ?, ?, ?, ?, ?, ?)");
            $criptPassword = crypt($password, 'lasdkfjgAasdAsdfaslcvfn');
            $clientId = self::$link->query("SELECT MAX(client_id) as max from autochemical.clients")->fetch_assoc()['max'] + 1;
            $query->bind_param("ssissis", $login, $criptPassword, $clientId,$VK, $interests, $userBloodGroup, $userBloodResus);
            $query->execute();
            return $clientId;
        }
        else return -1;
    }
    static function getUser($login, $password){
        $query = self::$link->prepare("SELECT client_id, password, login from autochemical.clients where login=?");
        $query->bind_param("s", $login);
        $query->execute();
        return $query->get_result()->fetch_assoc();
    }

    //Поиск товаров, если не пустой запрос
    static function getGood($brand, $chemicalType,$description, $name, $maximalPrice = 1000000, $minimalPrice = 0){
        $queryString = "SELECT image, productName, brandName, typeName, price, description
        from autochemical.products  
        join types on products.chemicalType_ID = types.typeId 
        join brands on products.chemicalBrand_ID = brands.brand_id 
        where (price between ? and ?) ";
        if($brand != -1){
            $queryString = $queryString.'and brandName = ? ';
        }
        if($description != " " && $description != ""){
            $queryString = $queryString . ' and (description LIKE ?)';
            $description = '%'.$description.'%';
        }
        if($name != " " && $name != ""){
            $queryString = $queryString . ' and (productName LIKE ?)';
            $name = '%'.$name.'%';
        }
        if($chemicalType != -1){
            $queryString = $queryString.' and typeName = ? ';
        }
        if($description == "") $description = " ";
        if($name == "") $name = " ";
        $query = self::$link->prepare($queryString);
        if($description != "" && $name != "" && $description != " " && $name != " "){
            if($brand != -1 && $chemicalType != -1){
                $query->bind_param("iissii", $maximalPrice, $minimalPrice, $description, $name, $brand, $chemicalType);
            }
            else if($brand == -1 && $chemicalType == -1){
                $query->bind_param("iiss", $maximalPrice, $minimalPrice, $description, $name);
            }
            else if($brand != -1 || $chemicalType != -1){
                $needVar = ($brand == -1 ? $chemicalType : $brand);
                $query->bind_param("iissi",$minimalPrice, $maximalPrice, $description, $name, $needVar);
            }
        }
        else if(($description == "" || $description == " ") && $name != "" && $name != " "){
            if($brand != -1 && $chemicalType != -1){
                $query->bind_param("iisii", $maximalPrice, $minimalPrice, $name, $brand, $chemicalType);
            }
            else if($brand == -1 && $chemicalType == -1){
                $query->bind_param("iis", $maximalPrice, $minimalPrice, $name);
            }
            else if($brand != -1 || $chemicalType != -1){
                $needVar = ($brand == -1 ? $chemicalType : $brand);
                $query->bind_param("iisi",$minimalPrice, $maximalPrice, $name, $needVar);
            }
        }

        else if($description != "" && $description != " " && ($name == "" || $name == " ")){
            if($brand != -1 && $chemicalType != -1){
                $query->bind_param("iisii", $maximalPrice, $minimalPrice, $description, $brand, $chemicalType);
            }
            else if($brand == -1 && $chemicalType == -1){
                $query->bind_param("iis", $maximalPrice, $minimalPrice, $description);
            }
            else if($brand != -1 || $chemicalType != -1){
                $needVar = ($brand == -1 ? $chemicalType : $brand);
                $query->bind_param("iisi",$minimalPrice, $maximalPrice, $description, $needVar);
            }
        }


        else{
            if($brand != -1 && $chemicalType != -1){
                $query->bind_param("iiii", $maximalPrice, $minimalPrice, $brand, $chemicalType);
            }
            else if($brand == -1 && $chemicalType == -1){
                $query->bind_param("ii", $maximalPrice, $minimalPrice);
            }
            else if($brand != -1 || $chemicalType != -1){
                $needVar = ($brand == -1 ? $chemicalType : $brand);
                $query->bind_param("iii",$minimalPrice, $maximalPrice, $needVar);
            }

        }
        $query->execute();
        $newArray = array();
        $query = $query->get_result();
        while($assocResult = $query->fetch_assoc()){
            $newArray[] = $assocResult;
        }
        return $newArray;
    }
    static function getAllGood(){
        $queryString = "SELECT image, productName, brandName, typeName, price, description
        from autochemical.products
        join types on products.chemicalType_ID = types.typeId 
        join brands on products.chemicalBrand_ID = brands.brand_id";
        $newArray = array();
        $query = self::$link->query($queryString);
        while($assocResult = $query->fetch_assoc()){
            $newArray[] = $assocResult;
        }
        return $newArray;
    }

    static function getMaxPrice(){
        return self::$link->query("SELECT MAX(price) as max from autochemical.products")->fetch_assoc()['max'];
    }
    static function getMinPrice(){
        return self::$link->query("SELECT MIN(price) as min from autochemical.products")->fetch_assoc()['min'];
    }
}
?>
<?php
    include("data_base.php");
    DataBase::connect();

    if(isset($_GET["find"])){
        $query_result = DataBase::getGood(
            isset($_GET["brand"])? $_GET["brand"] : -1, 
            isset($_GET["type"])? $_GET["type"] : -1, 
            isset($_GET["description"])? $_GET["description"] : " ",
            isset($_GET["name"])? $_GET["name"] : " ",
            isset($_GET["maximum"]) ? $_GET["maximum"] : $_GET["maximum"] = DataBase::getMaxPrice(),
            isset($_GET["minimum"]) ? $_GET["minimum"] : $_GET["minimum"] = DataBase::getMinPrice());
    }
    else {
        $query_result = DataBase::getAllGood();
    }        
?>


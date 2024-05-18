<?php
    class dataBase{
        private static mysqli $link;
        private static bool $isConnect = false;
        public static function connect(){
            if(!self::$isConnect){
                self::$isConnect = true;
                self::$link = new mysqli("localhost", "root","","autochemical");
            }
        }
        static function getAllGood(){ 
            $queryString = "SELECT  p.image, p.productName, b.brandName, t.typeName, p.price, 
                                    p.description, p.chemicalType_ID, p.chemicalBrand_ID
                            from autochemical.products p
                            join types t on p.chemicalType_ID = t.typeId 
                            join brands b on p.chemicalBrand_ID = b.brand_id";

            $goodArray = array();
            $query = self::$link->query($queryString);
            while($assocResult = $query->fetch_assoc()){
                $goodArray[] = $assocResult;
            }
            return $goodArray;
        }
}
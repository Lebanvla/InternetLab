<?php
    $joinStr = " join types on products.chemicalType_ID = types.typeId join brands on products.chemicalBrand_ID = brands.brand_id ";
    $dataBaseConnection = mysqli_connect("localhost", "root","","autochemical", false, 0);
    if($_GET){

        
        $minimalPrice = filter_var($_GET['minimum'], FILTER_VALIDATE_INT); 
        $maximalPrice = filter_var($_GET['maximum'], FILTER_VALIDATE_INT); 
        $brand = filter_var($_GET['brand'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>4)));
        $type = filter_var($_GET['type'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>13)));
        $description =mysqli_real_escape_string($dataBaseConnection, $_GET['description']); 
        $name =mysqli_real_escape_string($dataBaseConnection, $_GET['name']); 
        
        

        

        //Создаём запрос к Базе данных
        $dataBaseQuery  = 'SELECT image, productName, brandName, typeName, price, description from autochemical.products'. $joinStr .'where ';
        
            if(!empty($minimalPrice))  {
                $dataBaseQuery  = $dataBaseQuery  .'price > '. $minimalPrice;
                if($maximalPrice != NULL || $brand != NULL || $type != NULL || $description != NULL || $name != NULL){
                    $dataBaseQuery  = $dataBaseQuery  .' and ';
                }
            }
            if(!empty($maximalPrice))  {
                $dataBaseQuery  = $dataBaseQuery  .' price < '. $maximalPrice;
                if($brand != NULL || $type != NULL || $description != NULL || $name != NULL) {
                    $dataBaseQuery  = $dataBaseQuery    .' and ';
                }
            }
            
            if(!empty($type))  {
                $dataBaseQuery  = $dataBaseQuery  .' chemicalType_ID = '. $type;
                if($brand != NULL || $description != NULL || $name != NULL) $dataBaseQuery  = $dataBaseQuery    .' and ';
            }

            
            if(!empty($brand))  {
                $dataBaseQuery  = $dataBaseQuery  .' chemicalBrand_ID = '. $brand;
                if($description != NULL || $name != NULL) $dataBaseQuery  = $dataBaseQuery  .' and ';
            }

            if(!empty($name))  {
                $dataBaseQuery  = $dataBaseQuery  .' productName LIKE \'%'. $name.'%\'';
                if($description != NULL)$dataBaseQuery  = $dataBaseQuery  .' and ';
            }


            if(!empty($description))  {
                $dataBaseQuery  = $dataBaseQuery  .' description LIKE \'%'. $description.'%\'';
            }

            if(empty($description) && empty($brand) && empty($name) && empty($type) && empty($maximalPrice) && empty($minimalPrice)) {
                $dataBaseQuery.='1 = 1';
            }
    }else {
        $dataBaseQuery  = 'SELECT image, productName, brandName, typeName, price, description from autochemical.products '. $joinStr. ' WHERE 1 = 1';
    }
        
    
    if($dataBaseConnection != NULL) {
        $query_result = $dataBaseConnection-> query($dataBaseQuery);
    } 
    $output = array();
    while($row = $query_result->fetch_array()) {
        $output[] = $row;
    }
?>


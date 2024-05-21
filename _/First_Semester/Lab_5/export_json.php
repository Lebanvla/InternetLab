<?php
include 'PHP/dataBaseWork.php';


if($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_Post["export"])){
    dataBase::connect();
    $fileName = "temp/products__exported.json";
    $goodArray = dataBase::getAllGood();
    if(isset($goodArray)){
        $myJSON = fopen($fileName, 'w');
        if($myJSON != false){
            $count = 0;
            $size = count($goodArray);
            $textInFile = "{\n\"total\": ".$size .",\n\"items\": \n[";
            $uploadDir = 'D:/XAMPP/htdocs/InternetLab/Lab_5/temp/';
            foreach($goodArray as $good){
                $count++;
                $str = "{\n". '"image": "'. (string)($good["image"]). '"'.','."\n".
                        ' "productName": "'. str_replace("\r\n", "\\n", str_replace('"', '\"', ($good["productName"]))). '"'.','."\n".
                        ' "brandName": "'. ($good["brandName"]). '"'.','."\n".
                        ' "typeName": "'. ($good["typeName"]). '"'.','."\n".
                        ' "price": "'. (string)($good["price"]). '"'.','."\n".
                        ' "description": "'. str_replace("\r\n", "\\n", str_replace('"', '\"', ($good["description"]))). '"'.','."\n".
                        ' "chemicalType_ID": "'. (string)($good["chemicalType_ID"]). '"'.','."\n".
                        ' "chemicalBrand_ID": "'. (string)($good["chemicalBrand_ID"]). '"'."\n".
                        "},";
                if($count == $size){
                    $str = substr ($str, 0, strlen ($str)-1);
                }
                $textInFile = $textInFile.$str. "\n";
            }
            $textInFile.="]}";
            $urlLoadDir = $_SERVER["DOCUMENT_ROOT"]. "/temp/";
            fwrite($myJSON, $textInFile);
            $fileLenght = strlen($textInFile);

            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_URL, 'http://localhost/InternetLab/Lab_5/PHP/worker.php');
            curl_setopt($ch, CURLOPT_POSTFIELDS, ['export_file' => "@" . $urlLoadDir . "products__exported.json"]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json", "Content-Lenght: $fileLenght"));
            $response = curl_exec($ch);
            curl_close($ch);
            unlink("temp/products__exported.json");
            echo $response;
        }
    }
}
?>
<?php
include("dataBaseWork.php");
if(isset($_POST["change_data_base"])){
    if(!$_FILES){
        throw new Exception("Файл не отправлен");
    }
    $newName = $_POST["product_name"];
    $oldName = $_POST["old_product_name"];
    $newDescription = $_POST["product_description"];
    $newPrice = $_POST["product_price"];
    $newType = $_POST["product_types"];
    $newBrand = $_POST["product_brands"];

    $newPrice = filter_var($newPrice, FILTER_VALIDATE_INT); 
    $newBrand = filter_var($newBrand, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>4)));
    $newType = filter_var($newType, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>12)));
    $newName = isset($newName) ? $newName : null;
    $newDescription = isset($newDescription)? $_POST["product_description"] : null;
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/InternetLab/Lab_7/productpicture/';
    $oldImage = $_SERVER['DOCUMENT_ROOT'] . '/InternetLab/Lab_7/productpicture/' . $_POST["old_image_name"].".png";

    try{
        if($_FILES && $newPrice && $newBrand && $newType && isset($newName) && isset($newDescription)){
            if (!file_exists($uploadDir))
            {
                mkdir($uploadDir);
            }
            $file = array_shift($_FILES);
            if (!move_uploaded_file($file['tmp_name'], $uploadDir . $file['name']))
            {
                throw new mysqli_sql_exception("Файл не создан");
            }
            unlink($oldImage);
            $fileName = pathinfo($uploadDir . $file['name'], PATHINFO_FILENAME);
            try{
            productTable::changeProductByName($oldName, $newName, $newPrice, $fileName, $newDescription, $newBrand, $newType);
            }catch(mysqli_sql_exception $ex){
                throw new mysqli_sql_exception($ex->getMessage());
            }
            header('Location: ../productTable.php');

        }
    }catch(Exception $er){
        logWriter($er->getMessage());
    }
}
else throw new Exception("Не создаёт POST");

?>
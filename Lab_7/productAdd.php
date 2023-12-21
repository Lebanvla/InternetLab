<?php include 'PHP/dataBaseWork.php';
    $userArray = array('product_price'=>"", 'product_description'=>"", 'product_name'=>"", 'product_brand'=>'', 'product_type'=>'');
    $isError = false;
    $stringError = "";
    if($_POST){
        logWriter("В функции, для создания продукта");
        $price = filter_var($_POST['product_price'], FILTER_VALIDATE_INT); 
        $brand = filter_var($_POST['product_brands'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>4)));
        $type = filter_var($_POST['product_types'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>12)));
        $name = isset($_POST["product_name"]) ? $_POST["product_name"] : null;
        $description = isset($_POST["product_description"]) ? $_POST["product_description"] : null;
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/InternetLab/Lab_7/productpicture/';
        logWriter($uploadDir."\n".var_export($_FILES, true));
        if($_FILES && $price && $brand && $type && $name && $description){
            if (!file_exists($uploadDir))
            {
                mkdir($uploadDir);
            }
            $file = array_shift($_FILES);
            if (!move_uploaded_file($file['tmp_name'], $uploadDir . $file['name']))
            {
                logWriter("Файл не создан");
            }
            else{
                $fileName = pathinfo($uploadDir . $file['name'], PATHINFO_FILENAME);
                try{
                    logWriter("Начинает добавлять продукт");
                    productTable::addNewProduct($name, $price, $fileName, $description, $brand, $type);
                    logWriter("Добавил продукт");
                }catch(mysqli_sql_exception $ex){
                    logWriter($ex->getMessage());
                }
                header('Location: productTable.php');
        }
        }
        else {
                $isError = true;
                $stringError = '<div class = "row col-12" style="color:red;">Ошибка ввода данных<br> Переменные: <br>' . ($name != null ? "" : "Имя пусто<br> ").  ($price != null? "" : "Цена пуста <br>"). ($brand!= null? "": "Брэнд пуст<br>") . ($type!= null? "" : "Тип пуст<br>") .( $description!= null ? "" : "Описание пусто <br></span>");
                $userArray = array("product_name"=> $name, "product_price"=>$price, "product_brand"=>$brand, "product_type"=> $type, "product_description"=>$description);
            }    
}
?>
<?php 
        include 'PHP/header.php';
        if($isError){
            echo($stringError);
        }
?>
    <main class = "container text-center">
        <form action="productAdd.php" method="post" class="form-inline" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <input type="text" id="productName" name="product_name" class="sr-only" placeholder="Введите имя продукта" value = <?php echo $userArray['product_name'] !=null ? "'".$userArray['product_name']."'" : ""?>>
                <select id="brand" name="product_brands" class="sr-only">
                    <option value="0" <?php $userArray['product_brand'] == null ? "selected": ""?>>Выберите бренд продукта</option>
                    <option value="1" <?php $userArray['product_brand'] == 1 ? "selected": ""?>>Grass</option>
                    <option value="2" <?php $userArray['product_brand'] == 2 ? "selected": ""?> >MyMuse</option>
                    <option value="3" <?php $userArray['product_brand']== 3 ? "selected": ""?>>Detail</option>
                    <option value="4" <?php $userArray['product_brand'] == 4 ? "selected": ""?>>DutyBox</option>
                </select>
                <select id="type" name="product_types" class="sr-only">
                    <option value="0" <?php $userArray['product_type'] == null ? "selected": ""?>>Выберите тип продукта</option>
                    <option value="1" <?php $userArray['product_type'] == 1 ? "selected": ""?>>Автохимия, автокосметика</option>
                    <option value="2" <?php $userArray['product_type'] == 2 ? "selected": ""?>>Детейлинг</option>
                    <option value="3" <?php $userArray['product_type'] == 3 ? "selected": ""?>>Бытовая химия</option>
                    <option value="4" <?php $userArray['product_type'] == 4 ? "selected": ""?>>Экотовары</option>
                    <option value="5" <?php $userArray['product_type'] == 5 ? "selected": ""?>>Клининг</option>
                    <option value="6" <?php $userArray['product_type'] == 6 ? "selected": ""?>>Продукция для гостиниц</option>
                    <option value="7" <?php $userArray['product_type'] == 7 ? "selected": ""?>>Профессиональное оборудование для гостиниц</option>
                    <option value="8" <?php $userArray['product_type'] == 8 ? "selected": ""?>>Профессиональное оборудование для автомоек</option>
                    <option value="9" <?php $userArray['product_type'] == 9 ? "selected": ""?>>Профессиональное оборудование для пищепрома</option>
                    <option value="10" <?php $userArray['product_type'] == 10 ? "selected": ""?>>Химия для бассейнов</option>
                    <option value="11" <?php $userArray['product_type'] == 11 ? "selected": ""?>>Средства для профессиональной прачечной</option>
                    <option value="12" <?php $userArray['product_type'] == 12 ? "selected": ""?>>Химия на розлив</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <input type="file" class="sr-only" id="image" name="image" placeholder="Выберите картинку">
                <input type="number" class="sr-only" id="productPrice" name="product_price" placeholder="Введите цену продукта" value = <?php echo $userArray['product_price']?>>
                <input type="text" class="sr-only" id="productDescription" name="product_description" placeholder="Введите описание продукта" value = <?php echo $userArray['product_description']?>>
            </div>
            <button type="submit" class="btn btn-primary mb-2">Создать новый продукт</button>

        </form>
    </main>
<?php include 'PHP/footer.php';?>
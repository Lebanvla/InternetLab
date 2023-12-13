<?php include 'PHP/dataBaseWork.php';

    if($_POST){
        $price = filter_var($_POST['product_price'], FILTER_VALIDATE_INT); 
        $brand = filter_var($_POST['product_brands'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>4)));
        $type = filter_var($_POST['product_types'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>1, "max_range"=>12)));
        $name = isset($_POST["product_name"]) ? $_POST["product_name"] : null;
        $description = isset($_POST["product_description"]) ? $_POST["product_description"] : null;
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/InternetLab/Lab_6/productpicture/';
        logWriter($uploadDir."\n".var_export($_FILES, true));
        if($_FILES && $price && $brand && $type && isset($name) && isset($description)){
            if (!file_exists($uploadDir))
            {
                mkdir($uploadDir);
            }
            $file = array_shift($_FILES);
            if (!move_uploaded_file($file['tmp_name'], $uploadDir . $file['name']))
            {
                logWriter("Файл не создан");
            }
            $fileName = pathinfo($uploadDir . $file['name'], PATHINFO_FILENAME);
            try{
            productTable::addNewProduct($name, $price, $fileName, $description, $brand, $type);
            }catch(mysqli_sql_exception $ex){
                logWriter($ex->getMessage());
            }
            header('Location: productTable.php');
        }
        else logWriter("Ошибка ввода данных\n Переменные: \n" . (isset($name) ? $name : "Имя пусто ").  (($price) ? $price : "Цена пуста "). ($brand? $brand : "Брэнд пуст") . ($type? $type : "Брэнд пуст") . (isset($description) ? $description : "Описание пусто "));
    }
?>
<?php include 'PHP/header.php';?>


    <main class = "container text-center">
        <form action="productAdd.php" method="post" class="form-inline" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <input type="text" id="productName" name="product_name" class="sr-only" placeholder="Введите имя продукта">
                <select id="brand" name="product_brands" class="sr-only">
                    <option value="0">Выберите бренд продукта</option>
                    <option value="1">Grass</option>
                    <option value="2">MyMuse</option>
                    <option value="3">Detail</option>
                    <option value="4">DutyBox</option>
                </select>
                <select id="type" name="product_types" class="sr-only">
                    <option value="0">Выберите тип продукта</option>
                    <option value="1">Автохимия, автокосметика</option>
                    <option value="2">Детейлинг</option>
                    <option value="3">Бытовая химия</option>
                    <option value="4">Экотовары</option>
                    <option value="5">Клининг</option>
                    <option value="6">Продукция для гостиниц</option>
                    <option value="7">Профессиональное оборудование для гостиниц</option>
                    <option value="8">Профессиональное оборудование для автомоек</option>
                    <option value="9">Профессиональное оборудование для пищепрома</option>
                    <option value="10">Химия для бассейнов</option>
                    <option value="11">Средства для профессиональной прачечной</option>
                    <option value="12">Химия на розлив</option>
                </select>
            </div>
            <div class="form-group mb-2">
                <input type="file" class="sr-only" id="image" name="image" placeholder="Выберите картинку">
                <input type="number" class="sr-only" id="productPrice" name="product_price" placeholder="Введите цену продукта">
                <input type="text" class="sr-only" id="productDescription" name="product_description" placeholder="Введите описание продукта">
            </div>
            <button type="submit" class="btn btn-primary mb-2">Создать новый продукт</button>

        </form>
    </main>
<?php include 'PHP/footer.php'?>

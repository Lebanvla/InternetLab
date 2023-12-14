<?php
    include("PHP/dataBaseWork.php");

    if(isset($_COOKIE["changed_product_name"])){
        $oldProductName = $_COOKIE["changed_product_name"];
        unset($_COOKIE['changed_product_name']);
        setcookie('changed_product_name', null, time()-3600);
        include ("PHP/header.php");
        $productData = productTable::getProductByName($oldProductName);
        ?>
            <main class="container">
            <form action="PHP/changeLogic.php" method="post" class="form-inline" enctype="multipart/form-data">
                <div class="form-group mb-2">
                    <input type="text" id="productName" name="product_name" class="sr-only" placeholder="Введите имя продукта" value=<?php echo"'". $productData["productName"]."'";?>>
                    <select id="brand" name="product_brands" class="sr-only">
                        <option value="0" >Выберите бренд продукта</option>
                        <option value="1" <?php echo $productData["chemicalBrand_ID"] == 1 ?  " selected " : "";?>>Grass</option>
                        <option value="2" <?php echo $productData["chemicalBrand_ID"] == 2 ?  " selected " : "";?>>MyMuse</option>
                        <option value="3" <?php echo $productData["chemicalBrand_ID"] == 3 ?  " selected " : "";?>>Detail</option>
                        <option value="4" <?php echo $productData["chemicalBrand_ID"] == 4 ?  " selected " : "";?>>DutyBox</option>
                    </select>
                    <select id="type" name="product_types" class="sr-only">
                        <option value="0">Выберите тип продукта</option>
                        <option value="1" <?php echo $productData["chemicalType_ID"] == 1 ?  " selected " : "";?>>Автохимия, автокосметика</option>
                        <option value="2" <?php echo $productData["chemicalType_ID"] == 2 ?  " selected " : "";?>>Детейлинг</option>
                        <option value="3" <?php echo $productData["chemicalType_ID"] == 3 ?  " selected " : "";?>>Бытовая химия</option>
                        <option value="4" <?php echo $productData["chemicalType_ID"] == 4 ?  " selected " : "";?>>Экотовары</option>
                        <option value="5" <?php echo $productData["chemicalType_ID"] == 5 ?  " selected " : "";?>>Клининг</option>
                        <option value="6" <?php echo $productData["chemicalType_ID"] == 6 ?  " selected " : "";?>>Продукция для гостиниц</option>
                        <option value="7" <?php echo $productData["chemicalType_ID"] == 7 ?  " selected " : "";?>>Профессиональное оборудование для гостиниц</option>
                        <option value="8" <?php echo $productData["chemicalType_ID"] == 8 ?  " selected " : "";?>>Профессиональное оборудование для автомоек</option>
                        <option value="9" <?php echo $productData["chemicalType_ID"] == 9 ?  " selected " : "";?>>Профессиональное оборудование для пищепрома</option>
                        <option value="10" <?php echo $productData["chemicalType_ID"] == 10 ?  " selected " : "";?>>Химия для бассейнов</option>
                        <option value="11" <?php echo $productData["chemicalType_ID"] == 11 ?  " selected " : "";?>>Средства для профессиональной прачечной</option>
                        <option value="12" <?php echo $productData["chemicalType_ID"] == 12 ?  " selected " : "";?>>Химия на розлив</option>
                    </select>
                </div>
                <div class="form-group mb-2">
                    <input type="file" class="sr-only" id="image" name="image" placeholder="Выберите картинку">
                    <input type="number" class="sr-only" id="productPrice" name="product_price" placeholder="Введите цену продукта" value=<?php echo"'". $productData["price"]."'";?>>
                    <input type="text" class="sr-only" id="productDescription" name="product_description" placeholder="Введите описание продукта" value=<?php echo"'". $productData["description"]."'";?>>
                </div>
                <button type="submit" class="btn btn-primary mb-2" name = "change_data_base" value="change">Изменить продукт</button>
                <input type="hidden" name="old_product_name" value=<?php echo"'". $productData["productName"]."'";?>>
                <input type="hidden" name="old_image_name" value=<?php echo"'". $productData["image"]."'";?>>
            </form>
            </main>
        <?php
    }else throw new Exception("Ошибка пересылки данных");
    include ("PHP/footer.php");



?>
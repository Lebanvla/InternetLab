<?php 
    include 'PHP/dataBaseWork.php';
    if(!isset($_POST["needBrands"]))
        $_POST["needBrands"] = 0;
?>
<?php
    if (isset($_POST["delete"])){
        $name = $_POST["delete"];
        try{
            productTable::removeProductByName($name);
        }catch(mysqli_sql_exception $ex){
            logWriter($ex->getMessage());
        }
        header('Location: productTable.php');
    }
    else{
        logWriter("Нет post'а");
    }
?>
<?php include 'PHP/header.php';?>

    <main class = "col-10 container text-center">
    <form action="productTable.php" method="get" name="typeOfQuery">
            <div class="row col-4">
                <select id="needBrand" name="needBrands" class="sr-only">
                        <option value="0">Выберите Бренд</option>
                        <option value="1">Grass</option>
                        <option value="2">MyMuse</option>
                        <option value="3">Detail</option>
                        <option value="4">DutyBox</option>
                </select>
                <input type="submit" name = "selectBrand" value="yes" class="btn btn-primary col-2">
            </div>
    </form>


            <table class = "container table table-striped table-hover" style = >
                <tr class = "col-12">
                
                <th class = "col-2">Изображение</th>
                <th class = "col-2">Название товара</th>
                <th class = "col-2"">Бренд</th>
                <th class = "col-2">Вид химии</th>
                <th class = "col-2">Цена</th>
                <th class = "col-2">Описание товара</th>
                <th class = "col-2">Кнопки</th>
                

                </tr>
                <?php 
                if(!isset($_GET["needBrands"])){
                    $allProducts = productTable::getAllProducts();
                }
                else{
                    if($_GET["needBrands"] != 0)
                        $allProducts = productTable::getProductsByBrand($_GET["needBrands"]);
                    else $allProducts = productTable::getAllProducts();
                }$count = 0;
                foreach ($allProducts as $row): ?>
                        <tr class = "col-12">
                            <td class = "col-2"><img src="<?php echo htmlspecialchars("productpicture/".$row['image'].'.png')?>" width="115px" height="80px"></td>
                            <td class = "col-1"><?php echo htmlspecialchars($row['productName']) ?></td>
                            <td class = "col-1"><?php echo htmlspecialchars($row['brandName']) ?></td>
                            <td class = "col-1"><?php echo htmlspecialchars($row['typeName']) ?></td>
                            <td class = "col-1"><?php echo htmlspecialchars($row['price']) ?></td>
                            <td class = "col-3"><?php echo htmlspecialchars(substr($row['description'],0,200)) ?></td>
                            <td class = "col-2">
                            <form>
                                <a href=<?php echo "changeDataBase.php?productName=".str_replace(" ", "+", $row['productName'])?> class="btn btn-primary col-12" role="button">Изменить запись</a>
                                <br><br>
                                <button type="submit"  formaction ="productTable.php" formmethod="post" class="btn btn-danger col-12" name = "delete" id="delete" value=<?php echo '"' . htmlspecialchars($row["productName"]). '"'?>>Удалить запись</button>
                            </form>
                            </td>
                        </tr>
                <?php endforeach; ?>
            </table>
            <form action="productAdd.php" method="get">
                    <div class="row col-12">
                        <input type="submit" name = "add" value="Добавить новый продукт" class="btn btn-primary col-2">
                    </div>
            </form>
    </main>
    <br>
<?php include 'PHP/footer.php';?>

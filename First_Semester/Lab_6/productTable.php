<?php include 'PHP/header.php';?>
<?php include 'PHP/dataBaseWork.php';?>

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
                

                </tr>
                <?php 
                if(!isset($_GET) || $_GET["needBrands"] == 0){
                    $allProducts = productTable::getAllProducts();
                }
                else{
                    $allProducts = productTable::getProductsByBrand($_GET["needBrands"]);
                }
                foreach ($allProducts as $row): ?>    
                    <tr class = "col-12">
                        <td class = "col-2"><img src="<?php echo htmlspecialchars("productpicture/".$row['image'].'.png')?>" width="115px" height="80px"></td>
                        <td class = "col-2"><?php echo htmlspecialchars($row['productName']) ?></td>
                        <td class = "col-2"><?php echo htmlspecialchars($row['brandName']) ?></td>
                        <td class = "col-2"><?php echo htmlspecialchars($row['typeName']) ?></td>
                        <td class = "col-2"><?php echo htmlspecialchars($row['price']) ?></td>
                        <td class = "col-2"><?php echo htmlspecialchars(substr($row['description'],0,200)) ?></td>
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
<?php include 'PHP/footer.php'?>

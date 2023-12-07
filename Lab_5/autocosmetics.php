<?php include 'PHP/header.php';?>
<?php include 'PHP/logic.php'?>
<main class = "col-10 container text-center">
    <form action="autocosmetics.php" method="get">
        <div class = "mb-3">
            <input type="number" id="minimum_price" class="form-control" name="minimum" placeholder="Введите нижний порог цены">
            <br>
            <input type="number" id="maximal_price" class="form-control" name="maximum" placeholder="Введите верхний порог цены">
        </div>
        <div class="mb-3">
                    <select name="brand" class="form-control">
                        <option value="" selected>Выберите производителя</option>
                        <option value="1">Grass</option>
                        <option value="2">MyMuse</option>
                        <option value="3">Detail</option>
                        <option value="4">DutyBox</option>
                    </select>
        </div>
        <div class="mb-3">
                    <select name="type" class="form-control">
                        <option value="" selected>Выберите тип товара</option>
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
                        <option value="13">Косметика для тела</option>
                    </select>
        </div>

                <div class="mb-3">
                    <textarea class="form-control" placeholder="Введите описание товара" name="description"></textarea>
                </div>
                <div class="mb-3">
                    <input type="text" name="name" placeholder="Введите название товара" value='' class="form-control">
                </div>
                <input type="submit" name = "find" value="Найти товары по данным характеристикам" class="btn btn-success">
                <input type="reset" name="clearFilter" class="btn btn-danger" value = "Очистить фильтр">

    </form>
    

    <?php
            
    ?>
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
            foreach ($query_result as $result): ?>
                <tr class = "col-12">
                    <td class = "col-2"><img src="<?php echo htmlspecialchars("productpicture/".$result['image'].'.png')?>" width="115px" height="80px"></td>
                    <td class = "col-2"><?php echo htmlspecialchars($result['productName']) ?></td>
                    <td class = "col-2"><?php echo htmlspecialchars($result['brandName']) ?></td>
                    <td class = "col-2"><?php echo htmlspecialchars($result['typeName']) ?></td>
                    <td class = "col-2"><?php echo htmlspecialchars($result['price']) ?></td>
                    <td class = "col-2"><?php echo htmlspecialchars(substr($result['description'],0,200)) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
</main>
<br>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src = "main.js"></script>
<?php include 'PHP/footer.php'?>

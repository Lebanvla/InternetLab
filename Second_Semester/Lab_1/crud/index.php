<?php
include ("ORM.php");
include ("../view/table.php");


/*
INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES ('1', 'test_brend');
INSERT INTO `brands` (`brand_id`, `brand_name`) VALUES ('2', 'test_brend2');
INSERT INTO `products` (`id`, `image`, `productName`, `chemicalTypeID`, `chemicalBrandID`, `price`, `description`) VALUES ('0', 'Grass_Icon', 'saadfgh', '2', '1', '12', 'asdfsadfv');
*/

if (isset ($_GET["action"])) {
    $typingORM = ORM::fabric($_GET["type"]);
    if ($_GET["action"] === "read_all" || $_GET["action"] == "read_by_brand") {
        $result = $_GET["action"] == "read_all" ? $typingORM->readAllRecords() :
            $typingORM->getRowByAttribute([
                "brand" => [
                    "value" => $_GET["brand"],
                    "type" => "i"
                ]
            ]);

        $headers = [];
        $types = [];
        switch ($_GET["type"]) {
            case "product":
                $headers = [
                    "image" => "Изображение",
                    "productName" => "Название",
                    "brand_name" => "Компания",
                    "typeName" => "Вид химии",
                    "price" => "Цена",
                    "description" => "Описание",
                    "change" => "Изменить",
                    "delete" => "Удалить",
                ];
                $types = [
                    0 => ["name" => "image", "type" => "picture"],
                    1 => ["name" => "productName", "type" => "str"],
                    2 => ["name" => "brand_name", "type" => "str"],
                    3 => ["name" => "typeName", "type" => "str"],
                    4 => ["name" => "price", "type" => "int",],
                    5 => ["name" => "description", "type" => "str"],
                    6 => ["name" => "change", "type" => "link",],
                    7 => ["name" => "delete", "type" => "form_button",],

                ];
                if (!isset ($result)) {
                    $result = [];
                }
                for ($index = 0; $index < count($result); $index++) {
                    $product_id = $result[$index]["id"];
                    $result[$index]["change"] = [
                        "link" => "http://localhost/InternetLab/Second_Semester/Lab_1/crud/?action=change&type=product&id={$product_id}",
                        "text" => "Изменить запись"
                    ];
                    $result[$index]["delete"] = [
                        "id" => $product_id,
                        "form_name" => "delete_product",
                        "text" => "Удалить запись"
                    ];

                }

                break;
            case "brand":
                $headers = [
                    "brand_name" => "Название компании",
                    "change" => "Изменить запись",
                    "delete" => "Удалить запись",
                    "getProducts" => "Найти продукты с этим брендом",
                ];
                $types = [
                    0 => ["name" => "brand_name", "type" => "str"],
                    1 => ["name" => "getProducts", "type" => "link"],
                    2 => ["name" => "change", "type" => "link"],
                    3 => ["name" => "delete", "type" => "form_button",],
                ];
                if (!isset ($result)) {
                    $result = [];
                }
                for ($index = 0; $index < count($result); $index++) {
                    $brand_id = $result[$index]["brand_id"];
                    $result[$index]["change"] = [
                        "link" => "http://localhost/InternetLab/Second_Semester/Lab_1/crud/?action=change&type=brand&id={$brand_id}",
                        "text" => "Изменить запись"
                    ];
                    $result[$index]["delete"] = [
                        "id" => $brand_id,
                        "form_name" => "delete_brand",
                        "text" => "Удалить запись"
                    ];
                    $result[$index]["getProducts"] = [
                        "link" => "http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=product&action=read_by_brand&brand={$brand_id}",
                        "text" => "Перейти к продуктам этой компании"
                    ];
                }
                break;
            default:
                throw new Exception("Invalid ORM type");
        }
        include ("../core/header.php");
        echo MakeTableByData($result, $types, $headers);
        ?>
        <a class="btn btn-info" role="button"
            href="http://localhost/InternetLab/Second_Semester/Lab_1/crud/?action=create&type=<?= $_GET["type"] ?>">
            Создать запись
        </a>
        <?php
        include ("../core/footer.php");



    } else if ($_GET["action"] == "delete" && isset ($_GET["id"])) {
        switch ($_GET["type"]) {
            case "brand":
                $productORM = ORM::fabric("product");
                $rows = $productORM->getRowByAttribute([
                    "brand" => [
                        "value" => $_GET["id"],
                        "type" => "i"
                    ]
                ]);
                if (is_null($rows)) {
                    $typingORM->deleteRecordByID($_GET["id"]);
                    header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=read_all");
                    die();
                } else {
                    header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=delete_dict&id=" . $_GET["id"]);
                    die();
                }
                ;


        }

    } else if ($_GET["action"] == "delete_dict") {
        include ("../core/header.php");
        ?>
                <div class="tect-center">
                    Вы уверены, что хотите удалить этот бренд вместе со всеми продутами? Если да, то
                    <form action="http://localhost/InternetLab/Second_Semester/Lab_1/crud/" method="post">
                        <button type="submit" class="btn btn-link">нажмите
                            сюда</button>
                        <input type="hidden" name="id" value=<?php echo $_GET["id"] ?>>
                        <input type="hidden" name="endingDelete" value="ok">
                    </form>
                    <a
                        href="http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=delete_dict_with_data&id=<?= $_GET["id"] ?>"></a>
                    иначе, если хотите изменить продукты, входящие в него
                    <a
                        href="http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=product&action=read_by_brand&brand=<?= $_GET["id"] ?>">нажмите
                        сюда</a>
                    или
                    <a href="http://localhost/InternetLab/Second_Semester/Lab_1/">
                        вернитесь на главную страницу
                    </a>
                </div>
            <?php
            include ("../core/footer.php");

    } else if ($_GET["action"] == "delete_dict_with_data") {
        $typingORM->deleteRecordByID($_GET["id"]);
        header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=read_all");
        die();
    } else if ($_GET["action"] == "create") {
        include ("../core/header.php");
        if ($_GET["type"] == "product") {
            ?>
                            <form name="product_create" enctype="multipart/form-data"
                                action="http://localhost/InternetLab/Second_Semester/Lab_1/crud/" method="post">
                                <div class="mb-3">
                                    <label for="productName" class="form-label">Название продукта</label>
                                    <input required pattern="^(?![\s.,!<>\/-]+$)[a-zа-яА-ЯA-Z0-9]+$" type="text" class="form-control"
                                        name="productName" aria-describedby="nameHelp" <?php
                                        if (isset ($_GET["isagain"]) && isset ($_GET["productName"])) {
                                            echo ("value = {$_GET["productName"]})");
                                        }
                                        ?>>
                                    <div id="nameHelp" class="form-text">Введите название продукта</div>
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Изображение продукта</label>
                                    <input required type="file" class="form-control" name="image" aria-describedby="imageHelp" <?php
                                    if (isset ($_GET["isagain"]) && isset ($_GET["image"])) {
                                        echo ("value = {$_GET["image"]})");
                                    }
                                    ?>>
                                    <div id="imageHelp" class="form-text">Введите изображение продукта</div>
                                </div>

                                <label for="price" class="form-label">Выберите бренд</label>
                                <select required class="form-select" aria-label="Выберите тип" name="brand">
                        <?php
                        $brands = ORM::fabric("brand")->readAllRecords();
                        for ($i = 0; $i < count($brands); $i++) {
                            echo ("<option value={$brands[$i]["brand_id"]}>{$brands[$i]["brand_name"]}" .
                                (isset ($_GET["isagain"]) && $brands[$i]["brand_id"] == $_GET["chemicalBrandID"] ? "selected" : "")
                                . "</option>");
                        }
                        ?>
                                </select>
                                <label for="price" class="form-label">Выберите тип</label>
                                <select required class="form-select" aria-label="Выберите тип" name="type">
                        <?php
                        $brands = ORM::fabric("type")->readAllRecords();
                        for ($i = 0; $i < count($brands); $i++) {
                            echo ("<option value={$brands[$i]["typeID"]}" .
                                (isset ($_GET["isagain"]) && $brands[$i]["typeID"] == $_GET["chemicalTypeID"] ? "selected" : "")
                                . ">{$brands[$i]["typeName"]}</option>");
                        }
                        ?>
                                </select>

                                <div class="mb-3">
                                    <label for="price" class="form-label">Цена продукта</label>
                                    <input required type="number" class="form-control" name="price" aria-describedby="priceHelp" <?php
                                    if (isset ($_GET["isagain"]) && isset ($_GET["price"])) {
                                        echo ("value = {$_GET["price"]})");
                                    }
                                    ?>>
                                    <div id="priceHelp" class="form-text">Введите цену продукта</div>
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Введите описание продукта</label>
                                    <input required pattern="^(?![\s.,!<>\/-]+$)[a-zа-яА-ЯA-Z0-9]+$" type="text" class="form-control"
                                        name="description" aria-describedby="imageHelp" <?php
                                        if (isset ($_GET["isagain"]) && isset ($_GET["description"])) {
                                            echo ("value = {$_GET["description"]})");
                                        }
                                        ?>>
                                    <div id="imageHelp" class="form-text">Введите описание продукта</div>
                                </div>
                                <input type="hidden" name="form" value="product" />


                                <button type="submit" class="btn btn-primary">Отправить</button>
                            </form>

            <?php
        } else if ($_GET["type"] == "brand") {
            ?>
                                <form name="product_create" action="http://localhost/InternetLab/Second_Semester/Lab_1/crud/" method="post">
                                    <div class="mb-3">
                                        <label for="brandName" class="form-label">Название бренда</label>
                                        <input required pattern="^(?![\s.,!<>\/-]+$)[a-zа-яА-ЯA-Z0-9]+$" type="text" class="form-control"
                                            name="brandName" aria-describedby="nameHelp" <?php
                                            if (isset ($_GET["isagain"]) && isset ($_GET["brandName"])) {
                                                echo ("value = {$_GET["brandName"]})");
                                            }
                                            ?>>
                                        <div id="nameHelp" class="form-text">Введите название бренда</div>
                                    </div>
                                    <input type="hidden" name="form" value="brand" />
                                    <button type="submit" class="btn btn-primary">Отправить</button>

                                </form>
            <?php
        }
        include ("../core/footer.php");

    } else if ($_GET["action"] == "change") {
        include ("../core/header.php");
        if ($_GET["type"] == "product") {
            $changedProduct = $typingORM->getRecordByID($_GET["id"]);
            ?>
                                <form name="product_create" enctype="multipart/form-data"
                                    action="http://localhost/InternetLab/Second_Semester/Lab_1/crud/" method="post">
                                    <div class="mb-3">
                                        <label for="productName" class="form-label">Название продукта</label>
                                        <input required pattern="^(?![\s.,!<>\/-]+$)[a-zа-яА-ЯA-Z0-9]+$" type="text" class="form-control"
                                            name="productName" aria-describedby="nameHelp" value=<?= htmlspecialchars($changedProduct["productName"]) ?>>
                                        <div id="nameHelp" class="form-text">Введите название продукта
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="image" class="form-label">Изображение продукта</label>
                                        <input type="file" class="form-control" name="image" aria-describedby="imageHelp"
                                            value=<?= $changedProduct["image"] ?>>
                                        <div id="imageHelp" class="form-text">Введите изображение продукта</div>
                                    </div>

                                    <label for="price" class="form-label">Выберите бренд</label>
                                    <select required class="form-select" aria-label="Выберите тип" name="brand">
                        <?php
                        $brands = ORM::fabric("brand")->readAllRecords();
                        for ($i = 0; $i < count($brands); $i++) {
                            echo ("<option value={$brands[$i]["brand_id"]}>{$brands[$i]["brand_name"]}" .
                                ($brands[$i]["brand_id"] == $$changedProduct["chemicalBrandID"] ? "selected" : "")
                                . "</option>");
                        }
                        ?>
                                    </select>
                                    <label for="price" class="form-label">Выберите тип</label>
                                    <select required class="form-select" aria-label="Выберите тип" name="product_type">
                        <?php
                        $brands = ORM::fabric("type")->readAllRecords();
                        for ($i = 0; $i < count($brands); $i++) {
                            echo ("<option value={$brands[$i]["typeID"]}" .
                                ($brands[$i]["typeID"] == $$changedProduct["chemicalTypeID"] ? "selected" : "")
                                . ">{$brands[$i]["typeName"]}</option>");
                        }
                        ?>
                                    </select>

                                    <div class="mb-3">
                                        <label for="price" class="form-label">Цена продукта</label>
                                        <input required type="number" class="form-control" name="price" aria-describedby="priceHelp"
                                            value=<?= $changedProduct["price"] ?>>
                                        <div id="priceHelp" class="form-text">Введите цену продукта</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Введите описание продукта</label>
                                        <input required pattern="^(?![\s.,!<>\/-]+$)[a-zа-яА-ЯA-Z0-9]+$" type="text" class="form-control" name="description"
                                            aria-describedby="imageHelp" value=<?= htmlspecialchars($changedProduct["description"]) ?>>
                                        <div id="imageHelp" class="form-text">Введите описание продукта</div>
                                    </div>
                                    <input type="hidden" name="product_update" value="product_update" />

                                    <input type="hidden" name="id" value=<?= $_GET["id"] ?> />
                                    <button type="submit" class="btn btn-primary">Отправить</button>
                                </form>

            <?php
        } else if ($_GET["type"] == "brand") {
            $changedBrand = $typingORM->getRecordByID($_GET["id"]);

            ?>
                                    <form name="product_create" action="http://localhost/InternetLab/Second_Semester/Lab_1/crud/" method="post">
                                        <div class="mb-3">
                                            <label for="brandName" class="form-label">Название бренда</label>
                                            <input required pattern="^(?![\s.,!<>\/-]+$)[a-zа-яА-ЯA-Z0-9]+$" type="text" class="form-control"
                                                name="brand_name" aria-describedby="nameHelp" value=<?= $changedBrand["brand_name"] ?>>
                                            <div id="nameHelp" class="form-text">Введите название бренда</div>
                                        </div>
                                        <input type="hidden" name="brand_update" value="brand_update" />
                                        <button type="submit" class="btn btn-primary">Отправить</button>

                                        <input type="hidden" name="brand_id" value=<?= $_GET["id"] ?> />
                                    </form>
            <?php
        }
        include ("../core/footer.php");

    }

} else if (isset ($_POST["form"])) {
    $typingORM = ORM::fabric($_POST["form"]);
    if ($_POST["form"] == "product") {
        $errors = [];
        if (!ctype_digit($_POST["price"])) {
            $errors["price"] = true;
        }
        if (!ctype_digit($_POST["type"])) {
            $errors["type"] = true;
        }
        if (!ctype_digit($_POST["brand"]))
            $errors["brand"] = true;
        $_POST["productName"] = trim($_POST["productName"]);
        $_POST["description"] = trim($_POST["description"]);

        $newPictureName = "";
        if (!empty ($_FILES["image"])) {
            $image = $_FILES["image"];
            if ($image["error"] !== UPLOAD_ERR_OK) {
                throw new Exception("Ошибка ввода файла");
            } else {
                $tmpName = $image["tmp_name"];
                $newPictureName = md5(file_get_contents($_FILES['image']['tmp_name'])) . ".png";
                $success = move_uploaded_file($tmpName, $_SERVER["DOCUMENT_ROOT"] . "/InternetLab/Second_Semester/common_resourses/picture/" . $newPictureName);
                if (!$success) {
                    echo $tmpName . "<br/>";
                    echo $_SERVER["DOCUMENT_ROOT"] . "/InternetLab/Second_Semester/common_resourses/picture/" . $newPictureName . "<br/>";
                    throw new Exception("Не удалось сохранить файл");
                }
            }
        }

        if (!($errors["price"] || $errors["type"] || $errors["brand"])) {
            $typingORM->createRow([
                "image" => $newPictureName,
                "productName" => $_POST["productName"],
                "chemicalTypeID" => $_POST["type"],
                "price" => $_POST["price"],
                "chemicalBrandID" => $_POST["brand"],
                "description" => $_POST["description"],
            ]);
            header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=product&action=read_all");
            die();
        } else {
            $link = "Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=product&action=create&isagain=1" .
                "&productName={$_POST["productName"]}" .
                "&image={$_POST["image"]}&chemicalTypeID={$_POST["type"]}&price={$_POST["price"]}&" .
                "chemicalBrandID={$_POST["brand"]}&description={$_POST["description"]}";
            $link = isset ($errors["price"]) ? "&error_price=1" : "";
            $link = isset ($errors["brand"]) ? "&error_brand=1" : "";
            $link = isset ($errors["type"]) ? "&error_type=1" : "";
            header($link);
        }
    } else if ($_POST["form"] == "brand") {
        if (isset ($_POST["brandName"])) {
            $typingORM->createRow(["brandName" => $_POST["brandName"]]);
            header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=read_all");
        } else
            header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=create&isagain=1");
    }
} else if (isset ($_POST["type"])) {
    $typingORM = ORM::fabric("brand");
    var_dump($_POST["type"]);
    switch ($_POST["type"]) {
        case "delete_product":
            $typingORM = ORM::fabric("product");
            echo ("here");
            $oldFile = (new Product)->getImageById($_POST["id"]);
            unlink($_SERVER["DOCUMENT_ROOT"] . "/InternetLab/Second_Semester/common_resourses/picture/" . $oldFile);
            $typingORM->deleteRecordByID($_POST["id"]);
            header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=product&action=read_all");
            die();
        case "delete_brand":
            $productORM = ORM::fabric("product");
            $rows = $productORM->getRowByAttribute([
                "brand" => [
                    "value" => $_POST["id"],
                    "type" => "i"
                ]
            ]);
            if (is_null($rows)) {
                $typingORM->deleteRecordByID($_POST["id"]);
                header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=read_all");
                die();
            } else {
                var_dump($rows);
                header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=delete_dict&id=" . $_POST["id"]);
                die();
            }
            ;

    }
} else if (isset ($_POST["endingDelete"])) {

    $typingORM = ORM::fabric("brand");
    $typingORM->deleteRecordByID($_POST["id"]);
    header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=read_all");
    die();
} else if (isset ($_POST["product_update"])) {
    $typingORM = new Product;
    $errors = [];
    if (!ctype_digit($_POST["price"])) {
        $errors["price"] = true;
    }
    if (!ctype_digit($_POST["product_type"])) {
        $errors["product_type"] = true;
    }
    if (!ctype_digit($_POST["brand"]))
        $errors["brand"] = true;

    $newPictureName = "";
    if (!empty ($_FILES["image"])) {
        $image = $_FILES["image"];
        if ($image["error"] === UPLOAD_ERR_NO_FILE) {
            $newPictureName = $typingORM->getImageById($_POST["id"]);

        } else if ($image["error"] !== UPLOAD_ERR_OK) {
            throw new Exception("Ошибка ввода файла");
        } else {
            $oldFile = (new Product)->getImageById($_POST["id"]);
            unlink($_SERVER["DOCUMENT_ROOT"] . "/InternetLab/Second_Semester/common_resourses/picture/" . $oldFile);
            $tmpName = $image["tmp_name"];
            $newPictureName = md5(file_get_contents($_FILES['image']['tmp_name'])) . ".png";
            $success = move_uploaded_file($tmpName, $_SERVER["DOCUMENT_ROOT"] . "/InternetLab/Second_Semester/common_resourses/picture/" . $newPictureName);
            if (!$success) {
                echo $tmpName . "<br/>";
                echo $_SERVER["DOCUMENT_ROOT"] . "/InternetLab/Second_Semester/common_resourses/picture/" . $newPictureName . "<br/>";
                throw new Exception("Не удалось сохранить файл");
            }
        }
    } else {
        $newPictureName = $typingORM->getImageById($_POST["id"]);
    }


    var_dump($_POST);
    $typingORM->updateRecord([
        "image" => $newPictureName,
        "productName" => $_POST["productName"],
        "chemicalTypeID" => $_POST["product_type"],
        "price" => $_POST["price"],
        "chemicalBrandID" => $_POST["brand"],
        "description" => $_POST["description"],
        "id" => $_POST["id"]
    ]);
    header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=product&action=read_all");
} else if (isset ($_POST["brand_update"])) {
    $typingORM = ORM::fabric("brand");
    $errors = [];

    $typingORM->updateRecord([
        "brand_name" => $_POST["brand_name"],
        "brand_id" => (int) $_POST["brand_id"],
    ]);
    header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/crud/?type=brand&action=read_all");

} else {
    header("Location: http://localhost/InternetLab/Second_Semester/Lab_1/");
    die();

}

?>
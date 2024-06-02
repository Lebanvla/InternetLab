<?php include 'PHP/header.php';?>

<body class = "container">
    <form method="POST"  action = "export_json.php" name ="export">
        <div class = "col-12 text-center form-group">
            <label for="fileLink"></label>
            <input type="text" class="form-control" id="fileLink" placeholder="Экспорт файла .json в /upload/products__exported.json"?>
        </div>
        <div class = "row justify-content-md-center">
            <input type="submit" name = "fileExport" class="btn btn-success col-3">
        </div>
    </form>
</body>



<?php include 'PHP/footer.php';?>

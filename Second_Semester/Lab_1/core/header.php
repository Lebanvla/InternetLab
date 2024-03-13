<html lang="ru">
<?php
$serverAddress = "http://localhost/InternetLab/Second_Semester/Lab_1/";
$commonResourses = "http://localhost/InternetLab/Second_Semester/" . "common_resourses/";
$pictures = $commonResourses . "pictures";
$bootstrappJS = $commonResourses . "bootsrapp/js";
$bootstrappCSS = $commonResourses . "bootsrapp/css";
$crudLink = $serverAddress . "crud/";
?>

<head>
    <link href=<?= $bootstrappCSS . "/bootstrap.min.css" ?> rel="stylesheet">
    <meta charset="utf-8">
    <title>
        Grass
    </title>
</head>

<body class="container">
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <div class="container-fluid">
                <a class="navbar-brand" href=<?= $serverAddress ?>>
                    Grass
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">


                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href=<?= $serverAddress ?>>
                                Домашняя страница(сброс)
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href=<?= $crudLink . "?type=product&action=read_all" ?>>Продукты</a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href=<?= $crudLink . "?type=brand&action=read_all" ?>>Бренды</a>
                        </li>


                    </ul>
                </div>
            </div>
        </nav>
    </header>
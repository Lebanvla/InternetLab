<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(empty($_SESSION["USER"])){
            $_SESSION["USER"] = array("isAuthorised" => false, "login" => "", "id" => "");
        }
        if(empty($_SESSION["registerForm"]) && $_SESSION["USER"]["isAuthorised"] == false){
            $_SESSION["registerForm"] = array("userLogin"=> "", "userPassword"=> "", "userPassword2"=> "", "userInterests"=> "", "userVK" => "",  "userBloodGroup" => "", "userBloodResus" =>"", 
                                                "passwordError" => "", "loginError" => "", "vkError" => "", "groupError" => "", "resusError" => "", "passwordErrorAuth" => "", "loginErrorAuth" => "");
        }
    
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css" type = "text/css">
    <link rel = "icon" href = "image/logos/grass_logo.png" type=”image/x-icon”>
    <script src="library.js"></script>


    <title>Grass.ru</title>
</head>
<body>
<header class="container px-5" >
        <div class = "row col-12" style = "font-size: x-small;">
            <div class=" col-2"  >
                <a href = "#"><img src = "image/logos/logo.png"></a>
            </div>
            
            <div class="   col-1"  >
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-0">
                    <div style = "font-size: x-small;">БЛОГ</div>
                </a>
            </div>

            <div class="   col-1"  >
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-0">
                    <div style = "font-size: x-small;">КАК ЗАКАЗАТЬ</div>
                </a>
            </div>
            
            <div class="col-1"  >
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-0">
                    <div ">ВОЗВРАТ</div>
                </a>
            </div>

            <div class="  col-1"  >
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-0">
                    <div ">АКЦИИ</div>
                </a>
            </div>

            <div class="  col-1"  >
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-0">
                    <div ">ДИЛЕРАМ</div>
                </a>
            </div>
        
            <div class="  col-1"  >
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-0">
                    <div ">ГДЕ КУПИТЬ</div>
                </a>
            </div>

            <div class=" col-1"></div>
            

            <div class ="  col-1"  >
                <div style = "padding-top: 3%;">
                Ваш город: 
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-0">Москва</a>
                </div>
            </div>
        
            <div class ="  col-1"  >
                <a href = "#" class="link-underline-light link-secondary link-underline-opacity-5">
                    <strong >8 800 505-77-77</strong>
                </a>
            </div>

            <div class ="  col-1"  >
                <a href = "#"  class="link-underline-light link-secondary link-underline-opacity-0" style = "text-decoration-thickness: 1px;">
                    <div>gs@grass.su</div>
                </a>
            </div>





        </div>

        <div class = "row col-12" style = "padding-top: 1%;">
            <div class = "col-2 dropdown position:relative;">
                <button class = " btn dropdown-toggle" styles = "background-color:#DAA520;" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="katalog">
                    <span style = "font-size: 0.75;">Каталог товаров</span>
                    <img src = "image/logos/logo_from_button.png" style = "margin-left: 10%; ">
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="dropdown-item col-2">            
                                Хиты продаж
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item col-2">
                                Косметика MyHouse
                        </button>
                    </li>
                    
                    <li>
                        <button class="dropdown-item col-2">
                                Автохимия, Автокосметика
                        </button>
                    </li>
                    
                    <li>
                        <button class="dropdown-item col-2">
                                Детейлинг
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Бытовая химия
                        </button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Бытовая химия
                        </button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Клининг
                        </button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Продукция для гостиниц
                        </button>
                    </li>

                        <button class="dropdown-item col-2">
                                Профессиональное оборудование для автомоек</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Моющие средства для пищепрома</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                DutyBox</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Промопродукция</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Химия для бассейнов</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Средства для профессиональных прачечных</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Химия на розлив</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Вместе выгоднее</button>
                    </li>

                    <li>
                        <button class="dropdown-item col-2">
                                Распродажа</button>
                    </li>
                    <li>
                        <form action = "SecretPage.php" method="post">
                            <input type="submit" name = "Secret" value="SecretPage" class="btn btn-secondary col-3" >
                        </form>
                </ul>
            </div>
            <div class = "col-7">
                <input type = "text" class="finder form-control col-md-4 " placeholder = "Искать на Grass">
            </div>
            <?php
            if($_SESSION["USER"]["isAuthorised"] == false){
                echo ('<div class = "col-3">Вы не зарегистрированы: <a href = "registration.php">Зарегистрироваться</a> или <a href = "authorisation.php">Войти</a></div>');
            }
            else echo('<div class = "col-3">Вы зашли как '. $_SESSION["USER"]["login"]. ' <a href = "PHP/logout.php">Выйти</a>');
            ?>
        </div>
</header>


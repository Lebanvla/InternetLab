<?php
    include 'PHP/header.php';
?>
<br><br><br><br>    
<div class = "container col-12">
    <form action = "PHP/userCheck.php" method="post">
            <?php
            echo('
            <div class = "row justify-content-md-center">
                <input class = "form-control " type="text" id="login" name="userLogin" style = "width: 50%;" value ="'.($_SESSION["registerForm"]["userLogin"]).'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "loginInfo" class ="col-6">
                    Введите логин'.$_SESSION["registerForm"]["loginError"].'
                </div>
                
            </div>
            
            <br>


            <div class = "row justify-content-md-center">
                <input class = "form-control" type="password" id="password" name="userPassword" style = "width: 50%;" value ="'.$_SESSION["registerForm"]["userPassword"].'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "passwordInfo" class ="col-6">
                    Введите пароль'.$_SESSION["registerForm"]["passwordError"].'
                </div>
            </div>
            <div class = "row justify-content-md-center">
                <input class = "form-control" type="password" id="password" name="userPassword2" style = "width: 50%;"value ="'.$_SESSION["registerForm"]["userPassword2"].'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "passwordInfo2" class ="col-6">
                    Повторите пароль
                </div>
            </div>


            <br>
            <div class = "row justify-content-md-center">
                <input class = "form-control" type="text" id="interests" name="userInterests" style = "width: 50%;" value ="'.$_SESSION["registerForm"]["userInterests"].'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "interesrInfo" class ="col-6">
                    Введите свои интересы
                </div>
            </div>
            <br>

            <div class = "row justify-content-md-center">
                <input class = "form-control" type="text" id="vk" name="userVK" style = "width: 50%;" value ="'.$_SESSION["registerForm"]["userVK"].'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "vklInfo" class ="col-6">
                    Введите свой ВК'.$_SESSION["registerForm"]["vkError"].'
                </div>
            </div>
            <br>


            <div class = "row justify-content-md-center">
                <input class = "form-control" type="text" id="bloodGroup" name="userBloodGroup" style = "width: 50%;" value ="'.$_SESSION["registerForm"]["userBloodGroup"].'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "bloodGroupInfo" class ="col-6">
                    Введите свою группу крови'.$_SESSION["registerForm"]["groupError"].'
                </div>
            </div>
            <br>

            <div class = "row justify-content-md-center">
                <input class = "form-control" type="text" id="bloodResus" name="userBloodResus" style = "width: 50%;" value ="'.$_SESSION["registerForm"]["userBloodResus"].'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "bloodResusInfo" class ="col-6">
                    Введите свой резус-фактор'.$_SESSION["registerForm"]["resusError"].'
                </div>
            </div>
            <br>
            <div class = "row col-12 justify-content-md-center">
                <div class = "col-5">Уже зарегистрированы?<a href = "authorisation">Войти</a></div>
            </div>
            <br>
            <div class = "row justify-content-md-center">
                <input type="submit" name = "registrationButton" value="Зарегистрироваться" class="btn btn-success col-3">
            </div>
            ');?>

    </form>
</div>
<br><br><br><br>
<?php include 'PHP/footer.php'?>

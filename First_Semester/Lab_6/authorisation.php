<?php include 'PHP/header.php'?>
<br><br><br><br>
<div class = "container col-12">
    <form action = "PHP/userCheck.php" method="post">
    <?php
        if(!isset($_COOKIE["authorisationBlock"])){
            echo'
            <div class = "row justify-content-md-center">
                <input class = "form-control " type="text" id="login" name="userLogin" style = "width: 50%;" value ="'.($_SESSION["registerForm"]["userLogin"]).'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "loginInfo" class ="col-6">
                    Введите логин'.$_SESSION["registerForm"]["loginErrorAuth"].'
                </div>
                
            </div>
            
            <br>


            <div class = "row justify-content-md-center">
                <input class = "form-control" type="password" id="password" name="userPassword" style = "width: 50%;" value ="'.$_SESSION["registerForm"]["userPassword"].'">
            </div>
            <div class = "row justify-content-md-center">
                <div id = "passwordInfo" class ="col-6">
                    Введите пароль'.$_SESSION["registerForm"]["passwordErrorAuth"].'
                </div>
            </div>
        <br>
            <div class = "row col-12 justify-content-md-center">
                <div class = "col-5">Не зарегистрированы?<a href = "registration.php"> Зарегистрироваться</a></div>
            </div>
            <br>
            <div class = "row justify-content-md-center">
                <input type="submit" name = "autorisationButton" value="Войти" class="btn btn-success col-3">
            </div>

        ';}
        else{
            echo '<div class = "row justify-content-md-center">Попробуйте регистрацию через час<\div>';
        }
            ?>

    </form>
</div>
<br><br><br><br>
<?php include 'PHP/footer.php'?>

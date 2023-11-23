<?php
    include("data_base.php");
    function checkLogin($needLogin){
        return filter_var($needLogin, FILTER_VALIDATE_EMAIL) !== false;
    }
    function checkPassword($needPassword){
        return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-])(?=.*[_])[A-Za-z\d_-]+$/', $needPassword) && strlen($needPassword) > 4;
    }

    function checkVK($VK){
        return filter_var($VK, FILTER_VALIDATE_URL) !== false;
    }

    function checkBloodGroup($num){
        return is_numeric($num) && (int)$num > 0 && (int)$num < 5;
    }

    function checkResusFactor($resus){
        return $resus == '+' || $resus == '-';
    }    


    session_start();
    DataBase::connect();

    if (isset($_POST["registrationButton"])){

        $errorNum = 0;
        if(!checkLogin($_POST["userLogin"])){
            $errorNum++;
            $_SESSION["registerForm"]["loginError"] = '<div style = "color:red"> Ошибка логина <\div>';
        }  
        else $_SESSION["registerForm"]["loginError"] = "";

        if(!(checkPassword($_POST["userPassword"])) || $_POST["userPassword"] != $_POST["userPassword2"]){
            $errorNum++;
            $_POST["userPassword"] = trim($_POST["userPassword"]);
            $_SESSION["registerForm"]["passwordError"] = '<div style = "color:red"> Ошибка пароля <\div>';
        }  
        else $_SESSION["registerForm"]["passwordError"] = "";

        if(empty($_POST["userInterests"])){
            $errorNum++;
        }
        if(!checkVK($_POST["userVK"])){
            $errorNum++;
            $_SESSION["registerForm"]["vkError"] = '<div style = "color:red"> Ошибка вк<\div>';
        }  
        else $_SESSION["registerForm"]["vkError"] = "";

        if(!checkBloodGroup($_POST["userBloodGroup"])){
            $errorNum++;
            $_SESSION["registerForm"]["groupError"] = '<div style = "color:red"> Ошибка группы крови <\div>';
        }  
        else $_SESSION["registerForm"]["groupError"] = "";

        if(!checkResusFactor($_POST["userBloodResus"])){
            $errorNum++;
            $_SESSION["registerForm"]["resusError"] = '<div style = "color:red"> Ошибка резус-фактора <\div>';
        }  
        else $_SESSION["registerForm"]["resusError"] = "";

        if($errorNum == 0){
            $id = DataBase::addUser($_POST["userLogin"], $_POST["userPassword"], $_POST["userInterests"], $_POST["userVK"], $_POST["userBloodResus"], $_POST["userBloodGroup"]) != -1;
            if ($id !=-1){
                    unset($_SESSION["registerForm"]);
                    $_SESSION["USER"]["ID"] = $id;
                    $_SESSION["USER"]["isAuthorised"] = true;
                    $_SESSION["USER"]["login"] = $_POST["userLogin"];
                    header('Location: ../main.php');
                    die();
                }
             else{
                $_SESSION["registerForm"]["userLogin"] = $_POST["userLogin"];
                $_SESSION["registerForm"]["userPassword"] = $_POST["userPassword"];
                $_SESSION["registerForm"]["userPassword2"] = $_POST["userPassword2"];
                $_SESSION["registerForm"]["userInterests"] = $_POST["userInterests"];
                $_SESSION["registerForm"]["userVK"] = $_POST["userVK"];
                $_SESSION["registerForm"]["userBloodGroup"] = $_POST["userBloodGroup"];
                $_SESSION["registerForm"]["userBloodResus"] = $_POST["userBloodResus"];
                    header('../registration.php');
                die();
             }
 
        }else{
            $_SESSION["registerForm"]["userLogin"] = $_POST["userLogin"];
            $_SESSION["registerForm"]["userPassword"] = $_POST["userPassword"];
            $_SESSION["registerForm"]["userPassword2"] = $_POST["userPassword2"];
            $_SESSION["registerForm"]["userInterests"] = $_POST["userInterests"];
            $_SESSION["registerForm"]["userVK"] = $_POST["userVK"];
            $_SESSION["registerForm"]["userBloodGroup"] = $_POST["userBloodGroup"];
            $_SESSION["registerForm"]["userBloodResus"] = $_POST["userBloodResus"];
            header('Location: ../registration.php');
            die();
        }
    }
    
    if(isset($_POST["autorisationButton"])){
        $result = DataBase::getUser($_POST["userLogin"], $_POST["userPassword"]);
        if(!empty($result)){
            if($result["password"] == crypt($_POST["userPassword"], 'lasdkfjgAasdAsdfaslcvfn')){
                $_SESSION["registerForm"]["loginErrorAuth"] = '';
                $_SESSION["USER"]["ID"] = $result["client_id"];
                $_SESSION["USER"]["isAuthorised"] = true;
                $_SESSION["USER"]["login"] = $_POST["userLogin"];
                unset($_SESSION["registerForm"]);     
                header('Location: ../main.php');
                die();
            }
            else{
                $_SESSION["registerForm"]["loginErrorAuth"] = '';
                $_SESSION["registerForm"]["userLogin"] = $_POST["userLogin"];
                $_SESSION["registerForm"]["userPassword"] = $_POST["userPassword"];
                $_SESSION["registerForm"]["passwordErrorAuth"] = '<div style = "color:red"> Неправильный пароль </div>';
                header('Location: ../authorisation.php');
                die();
            }
        }
        else{
            $_SESSION["registerForm"]["userLogin"] = $_POST["userLogin"];
            $_SESSION["registerForm"]["userPassword"] = $_POST["userPassword"];
            $_SESSION["registerForm"]["loginErrorAuth"] = '<div style = "color:red"> Нет логина в системе </div>';
            $_SESSION["registerForm"]["passwordErrorAuth"] = "";
            header('Location: ../authorisation.php');
            die();
        }
    }
?>


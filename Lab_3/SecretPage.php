<?php 
    session_start();
    if(isset($_POST["Secret"]))
    if($_SESSION["USER"]["isAuthorised"]){
        
        header('Location: autocosmetics.php');
        die();
    }
    else{
        header('Location: authorisation.php');
        die();
    }
?>
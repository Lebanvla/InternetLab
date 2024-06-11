<?php
    function add_log($text){
        file_put_contents("log.txt", var_export($text)."\n", FILE_APPEND);
    }

    function add_separator(){
        file_put_contents("log.txt", "----------------------------------------------"."\n", FILE_APPEND);
    }


    function separated_log($text){
        add_separator();
        add_log($text);
        add_separator();
    }
?>
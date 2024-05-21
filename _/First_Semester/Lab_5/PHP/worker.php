<?php
    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/InternetLab/Lab_5/upload/';
    $types = [
        'application/json',
    ];
    var_dump($_FILES);
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $log = fopen("log.txt", 'a');
        if($_FILES){
            $result = "";
            if (!file_exists($uploadDir))
            {
                mkdir($uploadDir);
            }
            $file = array_shift($_FILES);
            if (in_array($file['type'], $types))
            {
                if (move_uploaded_file($file['tmp_name'], $uploadDir . $file['name']))
                {
                    echo "<a href='/InternetLab/Lab_5/upload/{$file['name']}' download='{$file['name']}'>Ссылка на скачивание файла</a>";
                }
                else
                {
                    fwrite($log, 'Файл не был загружен\n');
                }
            }
            else
            {
                fwrite($log, 'Неверный тип обрабатываемого файла\n');
            }
        }
        else fwrite($log, "Post приходит, но файл нет\n");
        fclose($log);

    }

?>
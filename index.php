<?php
    $lab3_path = $_SERVER["DOCUMENT_ROOT"] . "/InternetLab";
    require_once $lab3_path . '/vendor/autoload.php';
    $app = new Silex\Application();
    $app["debug"] = true;
    $app->get('/check.json', function() use ($app) {
        $result = [
            'check'=> 'result'
        ];
        return $app->json($result);
    });

    $app->get('/', function() use ($app){
        
    foreach ($app['routes'] as $route) {
            echo 'Методы: ';
            echo '<br><br>';
            echo var_dump($route->getMethods());
            echo '<br><br>';
            echo 'Пути: ';
            echo '<br><br>';
            echo $route->getPath();
            echo '<br><br>';
            echo 'Паттерны: ';
            echo '<br><br>';
            echo $route->getPattern();
            echo '<br><br>';
        }
    });
    
    $app->run();
?>
<?php
    $port = 5173;
    define("lab3_path", $_SERVER["DOCUMENT_ROOT"] );
    define("database_path", lab3_path. '/core/high-level/orm.php');
    require_once lab3_path . '/vendor/autoload.php';
    require_once "/home/lebanvla/project/InternetLab/InternetLab/Second_Semester/Lab_3/Backend/core/low_level/log.php";
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    include(database_path);
    $app = new Silex\Application();



    $app->after(function (Request $request, Response $response) use($port) {
        $response->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", "Origin, Content-Type, Accept, Autorisation");
        $response->headers->set("Access-Control-Allow-Origin", "http://localhost:". $port);
        if($request->getMethod()=="OPTIONS"){
            $response->headers->set("Access-Controll-Allow-Credentials", "true");
        }
    });

    $app->before(function (Request $request) use ($app, $port) {
        
        if($request->getMethod()=="OPTIONS"){
            $response = new Response();
            $response->headers->set("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
            $response->headers->set("Access-Control-Allow-Headers", "Origin, Content-Type, Accept, Autorisation");
            $response->headers->set("Access-Control-Allow-Origin", "http://localhost:".$port);
            return $response;    
        }
    });


    
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = json_decode(file_get_contents('php://input'), true);
        
    }





    $app->get('/{type}-list.json', function($type) use ($app) {
        try{
            $product = ORM_fabric($type);
            return $app->json([
                $type ."s" =>$product->get_all_rows()]);
        }
        catch(Exception $e){
            return new Response("Internal server error", 500); 
        }
    });


    $app->get('/product-list-sorted/{id}.json', function($id) use ($app) {
        try{
            $product = ORM_fabric('product');
            return $app->json([
                "products" => $product->get_filtered_row(array('brand_id' => $id)), 
            ]);
        }
        catch(Exception $e){
            return new Response($e -> getMessage(), 500); 
        }
    });


    $app->get("get-{type}/{id}.json", function($type, $id) use ($app){
        try{
            $product = ORM_fabric($type);
            $result = $product->get_row_by_id($id);
            return $app->json($result);
        }
        catch(Exception $e){
            return new Response($e -> getMessage(), 500);
        }
    });



    $app->post('/delete-{type}', function($type, Request $request) use ($app){
        try{ 
            $orm = ORM_fabric($type);
            $orm->delete_record($_POST[$orm->get_id_name()]);
            return new Response(ucfirst($type).' deleted',200);
        }
        catch(Exception $e){
            return new Response($e->getMessage(), 500); 
        }
    });


    
    $app->post('/create-brand', function() use ($app) {
        try{
            $product = ORM_fabric("brand");
            $product->update_or_create_record(-1, $_POST);
            return new Response("Product created", 200);
        }
        catch(Exception $e){
            add_log($e->getFile() ."". $e->getLine());
            return new Response($e->getMessage(), 400); 
        }
    }
    );

    $app->post("/update-brand", function() use ($app) {
        try{
            $id = $_POST["id"];
            unset($_POST["id"]);
            $product = ORM_fabric("brand");

            $product->update_or_create_record($id, $_POST);
            return new Response(var_export($_POST), 200);
        }
        catch(Exception $e){
            return new Response($e->getMessage(), 500); 
        }
    });






    $app->post('/create-product', function($type) use ($app) {
        try{
            $product = ORM_fabric("product");
            // var_dump($_POST);

            if ($_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK){
                $name = md5(file_get_contents($_FILES['image']['tmp_name'])) . ".png";
                $_POST["image"] = $name;
            }
            $product->update_or_create_record(-1, $_POST);
            move_uploaded_file($_FILES["filename"]["tmp_name"], lab3_path . "Images". $name);
            return new Response(var_export($_FILES), 200);
        }
        catch(Exception $e){
            add_log($e->getFile() ."". $e->getLine());
            return new Response($e->getMessage(),500); 
        }
    });




    $app->options("/create-{type}", function($type) use ($app){
        return '';
    });
    

    $app->options("/update-{type}", function($type) use ($app){
        return '';
    });
    

    $app->options("/delete-{type}", function($type) use ($app){
        return '';
    });
    
    
    $app->run();
?>

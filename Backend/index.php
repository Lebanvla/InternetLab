<?php
    define("lab3_path", $_SERVER["DOCUMENT_ROOT"] . "/InternetLab/Backend");
    define("database_path", lab3_path. '/core/orm.php');
    require_once lab3_path . '/vendor/autoload.php';

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    
    include(database_path);
    $app = new Silex\Application();
    $app->after(function (Request $request, Response $response){
            $response->headers->set('Access-Control-Allow-Methods','GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers','Origin, Content-Type, Accept, Authorisation');
            if($request->getMethod() == 'OPTIONS'){
                $response->headers->set('Access-Control-Allow-Credentials','true');
            }
    });


    $app->get('/{type}-list.json', function($type) use ($app) {
        try{
            $product = ORM_fabric($type);
            return $app->json($product->get_all_rows());
        }
        catch(Exception $e){
            return new Response("Internal server error", 500); 
        }
    });


    $app->get('/product-list-sorted/{id}.json', function($id) use ($app) {
        try{
            $product = ORM_fabric('product');
            return $app->json($product->get_filtered_row(array('brand_id' => $id)));
        }
        catch(Exception $e){
            return new Response($e -> getMessage(), 500); 
        }
    });


    
    $app->put('/create-{type}', function($type) use ($app) {
        try{
            parse_str(
                file_get_contents('php://input'), 
                $_PUT
                );
            $product = ORM_fabric($type);
            $product->update_or_create_record(-1, $_PUT);
            return new Response("Product created", 200);
        }
        catch(Exception $e){
            add_log($e->getFile() ."". $e->getLine());
            return new Response(var_export($_PUT)); 
        }
    });


    $app->post('/update-{type}', function($type) use ($app) {
        try{
            $id = $_POST["id"];
            unset($_POST["id"]);
            $product = ORM_fabric($type);
            $product->update_or_create_record($id, $_POST);
            return new Response("Product updated", 200);
        }
        catch(Exception $e){
            add_log($e->getFile() ."". $e->getLine());
            return new Response($e->getMessage(),500); 
        }
    });


    $app->delete('/delete-{type}', function($type) use ($app){
        try{
            parse_str(
                file_get_contents('php://input'), 
                $_DELETE
                ); 
            $product = ORM_fabric($type);
            $product->delete_record($_DELETE["id"]);
            return new Response('Product deleted',200);
        }
        catch(Exception $e){
            return new Response("Noncorrect delete of product", 500); 
        }
    });


    
    
    $app->run();
?>
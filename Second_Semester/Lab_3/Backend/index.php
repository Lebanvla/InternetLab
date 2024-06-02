<?php
    define("lab3_path", $_SERVER["DOCUMENT_ROOT"] );
    define("database_path", lab3_path. '/core/orm.php');
    require_once lab3_path . '/vendor/autoload.php';

    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    include(database_path);
    $app = new Silex\Application();
    $app->after(function (Request $request, Response $response){
            $response->headers->set('Access-Control-Allow-Origin', "http://localhost:5174");
            $response->headers->set('Access-Control-Allow-Methods','GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers','Origin, Content-Type, Accept, Authorisation');
            if($request->getMethod() == 'OPTIONS'){
                $response->headers->set('Access-Control-Allow-Credentials','true');
            }
    });

    
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
                ]
            );
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
            $have_image = false;
            if ($_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK){
                    $name = md5(file_get_contents($_FILES['image']['tmp_name'])) . ".png";
                    $have_image = true;
                    $_PUT["image"] = $name;
            }
            $product = ORM_fabric($type);
            $product->update_or_create_record(-1, $_PUT);
            if($have_image){
                move_uploaded_file($_FILES["filename"]["tmp_name"], $name);
            }
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
            $have_image = false;
            
            if ($_FILES && $_FILES["filename"]["error"]== UPLOAD_ERR_OK){
                $name = md5(file_get_contents($_FILES['image']['tmp_name'])) . ".png";
                $old_file_name = $product->get_row_by_id($id);
                $_POST["image"] = $name;
                $have_image = true;
            }
            

            $product->update_or_create_record($id, $_POST);
            if($have_image){
                unlink($_SERVER["DOCUMENT_ROOT"] . "resourses" . $old_file_name);
                move_uploaded_file($_FILES["filename"]["tmp_name"], $name);
            }
            return new Response("Product updated", 200);
        }
        catch(Exception $e){
            add_log($e->getFile() ."". $e->getLine());
            return new Response($e->getMessage(),500); 
        }
    });


    $app->post('/delete-{type}', function($type) use ($app){
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
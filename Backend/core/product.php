<?php
    require_once("orm.php");
    class Products extends ORM{

        public function __construct(){}
        protected function get_fields(){
            return array(
                "name" => "s",
                "price" => 'i',
                'brand_id'=>'i',
                'group_id'=>'i',
                'description'=> 's',
            );
        }

        protected function get_table_name(){
            return 'products';
        }

    }

?>
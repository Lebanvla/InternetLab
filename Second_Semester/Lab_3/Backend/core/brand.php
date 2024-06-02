<?php
    require_once("orm.php");
    class Brands extends ORM{

        public function __construct(){}
        protected function get_fields(){
            return array(
                "name" => "s",
            );
        }

        protected function get_table_name(){
            return 'brands';
        }

    }

?>
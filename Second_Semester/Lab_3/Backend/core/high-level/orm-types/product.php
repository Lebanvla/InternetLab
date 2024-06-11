<?php
    require_once("/home/lebanvla/project/InternetLab/InternetLab/Second_Semester/Lab_3/Backend/core/high-level/orm.php");
    class Products extends ORM{

        public function __construct(){}
        protected function get_fields(){
            return array(
                "name" => "s",
                "price" => 'i',
                'brand_id'=>'i',
                'group_id'=>'i',
                'description'=> 's',
                'image'=> 's',
            );
        }

        public function get_id_name(){
            return "id";
        }

        protected function get_table_name(){
            return 'products';
        }


        protected function get_joins(){
            return " join  brands on products.brand_id=brands.brand_id join groups on groups.group_id=products.group_id ";
        }

    }

?>
<?php
    require_once("/home/lebanvla/project/InternetLab/InternetLab/Second_Semester/Lab_3/Backend/core/high-level/orm.php");
    class Groups extends ORM{

        public function __construct(){}
        protected function get_fields(){
            return array(
                "group_name" => "s",
            );
        }

        protected function get_joins(){
            return "";
        }
        
        public function get_id_name(){
            return "group_id";
        }

        protected function get_table_name(){
            return 'groups';
        }

    }

?>
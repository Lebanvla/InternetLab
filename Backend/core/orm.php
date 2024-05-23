<?php
    require_once("product.php");
    require_once("brand.php");
    require_once("group.php");
    require_once("data_base.php");
    class ORMExceptiom extends Exception {}

    function ORM_fabric(string $type) : ORM{
        switch($type){
            case "product":
                return new Products();
            case "brand":
                return new Brands();
            case "group":
                return new Groups();
            default:
                throw new InvalidArgumentException("Передан неверный аргумент");
        }
    }


    abstract class ORM{
        


        abstract protected function get_table_name();
        abstract protected function get_fields();


        public function get_all_rows(){
            return DataBase::query("select * from ". $this->get_table_name());
        }


        public function get_filtered_row($data){
            $sql = "select * from ".$this->get_table_name()." where ";
            $types = "";
            $fields = $this->get_fields();
            $values = [];
            foreach($data as $key => $value){
                if(array_key_exists($key, $fields)){   
                    $types .= $fields[$key];
                    $values[] = $value;
                    $sql .= $key . " = ?, ";
                }else{
                    throw new ORMExceptiom("Key ". $key. " not exist in this table");
                }
            }
            $sql = substr($sql,0,-2);
            return DataBase::prepared_query($sql, $types, $values);
        }

        public function delete_record($id){
            $sql = "delete from ".$this->get_table_name()." where id=?";
            $check = $this->get_row_by_id($id);
            if(count($check) === 0){
                throw new ORMExceptiom("This row not exist");
            }
            else{
                try{
                    DataBase::prepared_query($sql, "i", array($id));
                }
                catch(Exception $e){
                    throw new ORMExceptiom("Noncorrect delete of row");
                }
            }
        }

        public function get_row_by_id($id){
            $sql = "select * from " . $this->get_table_name(). " where id = ?";
            return DataBase::prepared_query($sql, "i", array($id));
        }


        public function update_or_create_record($id, $data){
            $fields = $this->get_fields();
            //Create new record
            if($id === -1 ){
                add_log("Create record");
                //Check argument count
                if(count($fields) == count($data) ){
                    $sql_firs_past = "Insert into ". $this->get_table_name(). " ( ";
                    $sql_second_past = " Values ( ";
                    $types = "";
                    $values = [];
                    //Arguments validation
                    $keys = array_keys($data);
                    foreach($keys as $key){
                        if(!in_array($key, array_keys($fields))){
                            throw new Exception("Key ". $key. " not exist");
                        }
                    
                        else{
                            $sql_firs_past .= $key . ", ";
                            $sql_second_past .= "?, ";
                            $values[] = $data[$key];
                            $types .= $fields[$key];
                        }
                    }
                    $sql = substr($sql_firs_past, 0, strlen($sql_firs_past) - 2). ") ";
                    $sql .= substr($sql_second_past, 0, strlen($sql_second_past) - 2) .")";
                    return DataBase::prepared_query($sql, $types, $values);

                }
                else throw new InvalidArgumentException("Incorrect arguments count. Need ". count($fields). ", given ". count($data));
            }
            // Update record
            else{
                $check = $this->get_row_by_id($id);
                if(count($check) == 0)
                    throw new ORMExceptiom("This record not exist");
                else{
                    $types = "";
                    $sql = "update ". $this->get_table_name() ." set ";
                    $keys = array_keys($data);
                    $values = [];
                    foreach($keys as $key){
                        if(!in_array($key, array_keys($fields))){
                            throw new ORMExceptiom("Key ". $key. " not exist");
                        }
                        else{
                            $sql .= $key . " = ?, "; 
                            $types.=$fields[$key];
                            $values[] = $data[$key];
                        }
                    }
                    $sql = substr($sql, 0, strlen($sql) - 2);
                    return DataBase::prepared_query($sql, $types, $values);
                }
            }
        }
    }



?>
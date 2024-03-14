<?php



include("../core/DataBase.php");

abstract class ORM
{
    abstract protected function getTypes();
    protected function mysqliresult_to_array(mysqli_result $result): array|null
    {
        $returningVal = [];
        while ($row = $result->fetch_assoc()) {
            $returningVal[] = $row;
        }
        return($returningVal == [] ? null : $returningVal);
    }
    public static function fabric(string $type)
    {
        switch ($type) {
            case "product":
                return new Product;
            case "brand":
                return new Brand;
            case "type":
                return new Type;
            default:
                throw new Exception("Invalid ORM type");
        }
    }


    public function updateRecord($AttributeValueArray)
    {
        $fields = array_keys($this->getTableFields());
        $sql = "update " . $this->getTableName() . " SET ";
        $values = [];
        foreach ($fields as $field) {
            if ($field === $this->idName() || !isset($AttributeValueArray[$field]))
                continue;
            $sql = $sql . $field . " = ?, ";
            $values[] = $AttributeValueArray[$field];
        }
        $sql = substr($sql, 0, -2) . substr($sql, -1);
        $sql = $sql . " where {$this->idName()} = ?";
        $sql = substr($sql, 0, -2) . substr($sql, -1);
        $values[] = $AttributeValueArray[$this->idName()];
        $query = DataBase::prepare($sql);
        echo $sql;
        $query->bind_param($this->getTypes(), ...$values);
        $query->execute();
    }

    abstract public function createRow(array $Values);

    abstract protected function getTableName(): string;
    abstract protected function getJoins(): string;
    abstract protected function getTableFields(): array;
    abstract protected function idName(): string;
    public function readAllRecords(): array|null
    {
        $sql = "select * from " . $this->getTableName() . " " . $this->getJoins();
        $result = DataBase::query($sql);
        $result = $this->mysqliresult_to_array($result);
        return $result;
    }

    public function deleteRecordByID(int $id)
    {
        $query = DataBase::prepare("delete from {$this->getTableName()} where {$this->idName()} = ?");
        $query->bind_param("i", $id);
        $query->execute();
    }
    public function getRecordByID(int $id)
    {
        $query = DataBase::prepare("select * from {$this->getTableName()} where {$this->idName()} = ?");
        $query->bind_param("i", $id);
        $query->execute();
        return $this->mysqliresult_to_array($query->get_result())[0];
    }
}



class Product extends ORM
{
    public function createRow(array $Values)
    {
        $new_id = ($this->mysqliresult_to_array(DataBase::query("select Max(id) as new_id from products")))[0]["new_id"] + 1;
        $sql = "INSERT Products(id, image, productName, chemicalTypeID, chemicalBrandID, price, description) 
        VALUES (?, ?, ?, ?, ?, ?, ?);";
        $query = DataBase::prepare($sql);
        $query->bind_param(
            "issiiis",
            $new_id,
            $Values["image"],
            $Values["productName"],
            $Values["chemicalTypeID"],
            $Values["chemicalBrandID"],
            $Values["price"],
            $Values["description"]
        );
        $query->execute();

    }
    function getTableName(): string
    {
        return "products";
    }

    function getRowByAttribute(array $AttributeValueArray)
    {
        if (count($AttributeValueArray) === 0) {
            return $this->readAllRecords();
        }
        $query = DataBase::prepare("select * from products" . $this->getJoins() . " where " .
            (isset($AttributeValueArray["brand"]) ? " chemicalBrandID = ? " : "") .
            (isset($AttributeValueArray["brand"]) && isset($AttributeValueArray["type"]) ? " and " : "") .
            (isset($AttributeValueArray["type"]) ? " chemicalTypeID = ? " : ""));

        if (isset($AttributeValueArray["brand"]) && isset($AttributeValueArray["type"])) {
            $typeString = "ii";
            $query->bind_param($typeString, $AttributeValueArray["brand"]["value"], $AttributeValueArray["types"]["value"]);
        } else if (!is_null($AttributeValueArray["brand"]) || !is_null($AttributeValueArray["brand"])) {
            $typeString = "i";
            $val = isset($AttributeValueArray["type"]) ? $AttributeValueArray["type"]["value"] : $AttributeValueArray["brand"]["value"];
            $query->bind_param($typeString, $val);
        }

        $query->execute();
        $result = $this->mysqliresult_to_array($query->get_result());
        return $result;
    }

    function getJoins(): string
    {
        return " join brands on products.chemicalBrandID=brands.brand_id join types on products.chemicalTypeID=types.typeID ";
    }

    function getTableFields(): array
    {
        return [
            "id" => "int",
            "image" => "picture",
            "productName" => "str",
            "chemicalTypeID" => "int",
            "type" => "str",
            "chemicalBrandID" => "int",
            "brand" => "str",
            "price" => "int",
            "description" => "str"
        ];
    }
    protected function getTypes()
    {
        return "ssiiisi";
    }

    protected function idName(): string
    {
        return "id";
    }
}


class Brand extends ORM
{
    public function createRow(array $Values)
    {
        $new_id = ($this->mysqliresult_to_array(DataBase::query("select Max(brand_id) as new_id from brands")))[0]["new_id"] + 1;
        $sql = "INSERT brands(brand_id, brand_name) 
        VALUES (?, ?);";
        $query = DataBase::prepare($sql);
        $query->bind_param(
            "is",
            $new_id,
            $Values["brandName"],
        );
        $query->execute();

    }
    function getTableName(): string
    {
        return "brands";
    }

    function getTableFields(): array
    {
        return [
            "brand_id" => "int",
            "brand_name" => "str",
        ];
    }

    function getJoins(): string
    {
        return "";
    }

    protected function idName(): string
    {
        return "brand_id";
    }
    protected function getTypes()
    {
        return "si";
    }
}

class Type extends ORM
{
    public function createRow(array $Values)
    {

    }
    protected function getTypes()
    {
        return "is";
    }

    function getTableName(): string
    {
        return "types";
    }

    function getTableFields(): array
    {
        return [
            "typeID" => "int",
            "typeName" => "str",
        ];
    }

    function getJoins(): string
    {
        return "";
    }

    protected function idName(): string
    {
        return "typeID";
    }

}

?>
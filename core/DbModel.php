<?php

namespace app\core;

abstract class DbModel extends Model
{
    abstract public function tableName():string;

    abstract public function attributes():array;

    abstract public function primaryKey():string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = [];
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attributes).") 
                    VALUES(".implode(',',$params).")");
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement ->execute();
        return true;
    }

    public function prepare($sql) {
        return Application::$app->db->prepare($sql);
    }

    public function findOne($where) // [email => ngovanthuan07@gmail.com, firstname => thuan]
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        // SELECT * FROM $tableName WHERE email = :email AND firstname
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item){
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }


    public function findProperty($conditions, $offset, $limit) {
        $tableName = $this->tableName();
        $sql = "SELECT * FROM $tableName";
        if(!empty($conditions) || $conditions !== null) {
            $sql .= " WHERE ";
            foreach ($conditions as $index =>$condition) {
                $column = $condition['column'];
                $operator = $condition['operator'];
                $value = $condition['value'];
                switch ($operator) {
                    case '=':
                        $value = is_string($value) ? "'". $value. "'" : $value;
                        $sql .= "$column = $value";
                        break;
                    case 'like':
                        $sql .= "$column LIKE '%$value%'";
                        break;
                    case '>':
                        $value = is_string($value) ? "'". $value. "'" : $value;
                        $sql .= "$column > $value";
                        break;
                    case '<':
                        $value = is_string($value) ? "'". $value. "'" : $value;
                        $sql .= "$column < $value";
                        break;
                    case '>=':
                        $value = is_string($value) ? "'". $value. "'" : $value;
                        $sql .= "$column >= $value";
                        break;
                    case '=<':
                        $value = is_string($value) ? "'". $value. "'" : $value;
                        $sql .= "$column =< $value";
                        break;
                }
                if($index !== count($conditions) - 1) {
                    $sql .= " AND ";
                }
            }
        }
        if($offset) {
            $sql .= " OFFSET $offset";
        }
        if($limit) {
            $sql .= " LIMIT $limit";
        }
        $statement = self::prepare($sql);
        $statement->execute();
        return $statement->fetchAll(Application::$app->db->pdo::FETCH_CLASS);
    }
}
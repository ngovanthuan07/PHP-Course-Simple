<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';
    public const RULE_UNIQUE = 'unique';

    public array $errors = [];

    public function loadData($data){
        foreach($data as $key => $value){
            if(property_exists($this,$key)){
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules():array;
    
    
    public function validate() {
        foreach($this->rules() as $attribute => $rules){
            $value = $this->{$attribute};
            foreach ($rules as $rule){
                $ruleName = $rule;
                if(!is_string($ruleName)){
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_REQUIRED && !$value){ // kiem tra co phai phan tu elf::RULE_REQUIRED va $value co ton tai hay ko
                    $this->addErrorForRule($attribute, self::RULE_REQUIRED);
                }
                if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)){
                    $this->addErrorForRule($attribute,self::RULE_EMAIL);
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']){
                    $this->addErrorForRule($attribute,self::RULE_MIN,$rule);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']){
                    $this->addErrorForRule($attribute,self::RULE_MAX, $rule);
                }
                if($ruleName === self::RULE_MATCH && $value !== $this->{$rule['match']}){
                    $this->addErrorForRule($attribute,self::RULE_MATCH, $rule);
                }

                if($ruleName === self::RULE_UNIQUE){
                    $className = $rule['class'];
                    $uniqueAttr = $rule['attribute'] ?? $attribute;
                    $tableName = $className::tableName();
                    $statement = Application::$app->db->pdo->prepare("SELECT * FROM $tableName WHERE $uniqueAttr = :attr");
                    $statement->bindValue(":attr", $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if($record){
                        // $this->addError($attribute, self::RULE_UNIQUE, ['field' =>  $attribute]);
                        // $this->addError($attribute, self::RULE_UNIQUE, ['field' =>  $this->labels()[$attribute]]);
                        // $this->addError($attribute, self::RULE_UNIQUE, ['field' =>  $this->getFirstError($attribute)]);
                        $this->addErrorForRule($attribute,self::RULE_UNIQUE, ['field' =>  $uniqueAttr]);
                    }

                }

            }
        }
        return empty($this->errors);
    }

    private function addErrorForRule(string $attribute, string $rule, $param = []){
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($param as $key => $value){
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;  // Array(['$attribute'] => Array([0] => $message))
    }


    public function addError(string $attribute, string $message){
        $this->errors[$attribute][] = $message;  // Array(['$attribute'] => Array([0] => $message))
    }

    public function errorMessages():array{
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be valid email address',
            self::RULE_MIN => 'Max length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
            self::RULE_UNIQUE => 'Record with this {field} already exist',
        ];
    }

    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }

    public function getFirstError($attribute){
        return $this->errors[$attribute][0] ?? false;
    }
}
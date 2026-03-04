<?php

namespace Core;

class Validation
{
    public $validations = [];

    public static function validate($rules, $data)
    {

        $validation = new self;

        foreach ($rules as $field => $rulesField) {

            foreach ($rulesField as $rule) {

                $valueField = $data[$field];

                if ($rule == 'confirmed') {

                    $validation->$rule($field, $valueField, $data["{$field}_confirmed"]);
                } elseif (str_contains($rule, ':')) {

                    $temp = explode(':', $rule);

                    $rule = $temp[0];

                    $ruleAr = $temp[1];

                    $validation->$rule($ruleAr, $field, $valueField);
                } else {

                    $validation->$rule($field, $valueField);
                }
            }
        }

        return $validation;
    }

    private function required($field, $value)
    {

        if (strlen($value) == 0) {

            $this->validations[$field] = "O campo $field é obrigatório.";
        }
    }

    private function email($field, $value)
    {

        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {

            $this->validations[$field] = "O campo $field é inválido.";
        }
    }

    private function confirmed($field, $value, $valueConfirmed)
    {

        if ($value != $valueConfirmed) {

            $this->validations[$field] = "O campo $field de confirmação está diferente.";
        }
    }

    private function unique($table, $field, $value)
    {

        if (strlen($value) == 0) {

            return;
        }

        $db = new Database(config('database'));

        $result = $db->query(

            query: "select * from $table where $field = :value",
            params: ['value' => $value]

        )->fetch();

        if ($result) {

            $this->validations[$field] = "O campo $field já está sendo usado.";
        }
    }

    private function min($min, $field, $value)
    {

        if (strlen($value) <= $min) {

            $this->validations[$field] = "O campo $field precisa ter um mínimo de $min caracteres.";
        }
    }

    private function max($max, $field, $value)
    {

        if (strlen($value) > $max) {

            $this->validations[$field] = "O cmapo $field precisa ter um máximo de $max caracteres.";
        }
    }

    private function strong($field, $value)
    {

        if (! strpbrk($value, "!#$%&'()*+,-./:;<=>?@[\]^_`{|}~")) {

            $this->validations[$field] = "O campo $field precisa de um caractere especial.";
        }
    }

    public function isInvalid($customName = null)
    {
        $key = 'validations';

        if ($customName) {

            $key .= '_' . $customName;
        }

        //usa push apenas se nao for ajax
        if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            flash()->push($key, $this->validations);
        }

        return count($this->validations) > 0;
    }

    public function errors()
    {
        return $this->validations;
    }
}

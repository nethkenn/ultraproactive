<?php 

namespace App\Services;
use Validator;
class Validator extends Validator
{

    public function validateFoo($attribute, $value, $parameters){  
        return $value == "foo";
    }
}
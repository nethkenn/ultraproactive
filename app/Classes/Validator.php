<?php

namespace MyApp\Services;

class Validator extends \Illuminate\Validation\Validator{

    public function validateFoo($attribute, $value, $parameters){  
        return $value == "foo"
    }
}
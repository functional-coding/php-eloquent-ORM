<?php

class Validator extends \Illuminate\Validation\Validator
{
    protected function replaceSomeOfArray($message, $attribute, $rule, $parameters)
    {
        return str_replace(':list', $this->getDisplayableAttribute($parameters[0]), $message);
    }

    protected function validateNotNull($attribute, $value, $parameters, $validator)
    {
        return !$this->validateNull($attribute, $value, $parameters, $validator);
    }

    protected function validateNull($attribute, $value, $parameters, $validator)
    {
        if (is_null($value)) {
            return true;
        }

        return false;
    }

    protected function validateSomeOfArray($attribute, $value, $parameters, $validator)
    {
        $validator->requireParameterCount(1, $parameters, 'some_of_array');

        if (is_string($value)) {
            $value = preg_split('/\s*,\s*/', $value);
        }
        $options = $this->getValue($parameters[0]);

        return count($value) == count(array_intersect($value, $options));
    }
}

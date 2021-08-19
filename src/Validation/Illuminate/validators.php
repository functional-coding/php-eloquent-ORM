<?php

return [
    'not_null' => function ($attribute, $value, $parameters, $validator) {
        return !$this['null']($attribute, $value, [], $validator);
    },

    'null' => function ($attribute, $value, $parameters, $validator) {
        if (is_null($value)) {
            return true;
        }

        return false;
    },

    'some_of_array' => function ($attribute, $value, $parameters, $validator) {
        $validator->requireParameterCount(1, $parameters, 'some_of_array');

        $value = preg_split('/\s*,\s*/', $value);
        $options = $this->getValue($parameters[0]);

        return count($value) == count(array_intersect($value, $options));
    },
];

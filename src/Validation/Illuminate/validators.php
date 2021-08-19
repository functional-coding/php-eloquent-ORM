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
];

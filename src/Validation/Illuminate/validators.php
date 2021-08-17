<?php

return [
    'not_null' => function ($attribute, $value, $parameters, $validator) {
        return !$this['null']($attribute, $value, [], $validator);
    },

    'not_null_if' => function ($attribute, $value, $parameters, $validator) {
        $validator->requireParameterCount(2, $parameters, 'not_null_if');

        $ifValue = $validator->getValue($parameters[0]);

        if ($ifValue != $parameters[1]) {
            return true;
        }

        return $this['not_null']($attribute, $value, [], $validator);
    },

    'null' => function ($attribute, $value, $parameters, $validator) {
        if (is_null($value)) {
            return true;
        }

        return false;
    },

    'null_if' => function ($attribute, $value, $parameters, $validator) {
        $validator->requireParameterCount(2, $parameters, 'null_if');

        $ifValue = $validator->getValue($parameters[0]);

        if ($ifValue != $parameters[1]) {
            return true;
        }

        return $this['null']($attribute, $value, [], $validator);
    },
];

<?php

return [
    'some_of_array' => function ($message, $attribute, $rule, $parameters) {
        return str_replace(':list', $this->getDisplayableAttribute($parameters[0]), $message);
    },
];

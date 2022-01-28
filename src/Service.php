<?php

namespace FunctionalCoding\ORM\Eloquent;

use ArrayAccess;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class Service extends \FunctionalCoding\Service
{
    protected function getValidationErrors($locale, $key, $data, $ruleLists, $names)
    {
        $validator = Validator::make([], [], [], []);
        $data = (new Collection($data))->toArray();

        if (preg_match('/\.\*$/', $key)) {
            $arrayKey = preg_replace('/\.\*$/', '', $key);
            $array = Arr::get($data, $arrayKey);
            $rules = [];
            if (!is_array($array) && !($array instanceof ArrayAccess)) {
                throw new \Exception($arrayKey.' key must has array rule');
            }
            foreach ($array as $i => $v) {
                $rules[$arrayKey.'.'.$i] = array_keys($ruleList);
                $names[$arrayKey.'.'.$i] = str_replace('*', $i, $names[$key]);
            }
            unset($rules[$key], $names[$key]);
        } else {
            $rules = [$key => array_keys($ruleList)];
        }

        $messages = include 'Validation'.DIRECTORY_SEPARATOR.'lang'.DIRECTORY_SEPARATOR.explode('-', $locale)[0].'.php';

        $validator->setData($data);
        $validator->setRules($rules);
        $validator->setCustomMessages($messages);
        $validator->setAttributeNames($names);
    }
}

<?php

namespace FunctionalCoding\Illuminate;

class Query extends \Illuminate\Database\Eloquent\Builder
{
    public function select()
    {
        $args = func_get_args();
        $args = 1 == count($args) ? $args[0] : $args;
        $args = is_array($args) ? $args : [$args];

        foreach ($args as $i => $arg) {
            $args[$i] = $this->getModel()->getTable().'.'.$arg;
        }

        return parent::select($args);
    }

    public function whereIn()
    {
        $args = func_get_args();

        if (false === strpos($args[0], '.')) {
            $args[0] = $this->getModel()->getTable().'.'.$args[0];
        }

        return parent::whereIn(...$args);
    }

    public function toSqlWithBindings()
    {
        $str = str_replace('?', "'?'", parent::toSql());

        return vsprintf(str_replace('?', '%s', $str), $this->getBindings());
    }
}

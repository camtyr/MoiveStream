<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    protected $request;
    protected $builder;
    protected $filterable = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $name => $value) {
            $method = 'filter' . ucfirst($name);
            if (method_exists($this, $method) && $value !== null && $value !== '') {
                $this->$method($value);
            }
        }

        return $this->builder;
    }

    protected function filters()
    {
        return $this->request->only($this->filterable);
    }
}
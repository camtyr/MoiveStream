<?php

namespace App\Filters;

class MovieFilter extends QueryFilter
{
    protected $filterable = ['title', 'release_year', 'genre', 'sort'];

    public function filterTitle($value)
    {
        return $this->builder->where('title', 'LIKE', '%' . $value . '%');
    }

    public function filterRelease_year($value)
    {
        return $this->builder->where('release_year', $value);
    }

    public function filterGenre($values)
    {
        $values = is_array($values) ? $values : [$values];

        return $this->builder->whereHas('genres', function ($query) use ($values) {
            $query->whereIn('slug', $values);
        });
    }

    public function filterSort($value)
    {
        if ($value === 'newest') {
            return $this->builder->orderByDesc('created_at');
        }

        if ($value === 'oldest') {
            return $this->builder->orderBy('created_at');
        }

        return $this->builder;
    }
}

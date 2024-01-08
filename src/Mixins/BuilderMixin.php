<?php

namespace CodeLink\Booster\Mixins;

class BuilderMixin
{
    public function whereLike()
    {
        return function($attribute, $search) {
            return $this->whereRaw("LOWER($attribute) like ?", '%' . strtolower($search) . '%');
        };
    }

    public function orWhereLike()
    {
        return function($attribute, $search) {
            return $this->orWhereRaw("LOWER($attribute) like ?", '%' . strtolower($search) . '%');
        };
    }

    public function whereSearch()
    {
        return function(string|array $attributes, $search) {
            return $this->when($search, function($query, $search) use ($attributes) {
                $query->where(function($query) use ($attributes, $search) {
                    collect($attributes)->each(function($attribute, $index) use ($query, $search) {
                        $index === 0
                        ? $query->whereLike($attribute, $search)
                        : $query->orWhereLike($attribute, $search);
                    });
                });
            });
        };
    }
}

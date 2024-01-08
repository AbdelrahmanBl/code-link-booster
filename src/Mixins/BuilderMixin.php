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
        return function(string|array $attributes, $search, callable $modifyQuery = null) {
            return $this->when($search, function($query, $search) use ($attributes, $modifyQuery) {
                $query->where(function($query) use ($attributes, $search, $modifyQuery) {
                    collect($attributes)->each(function($attribute, $index) use ($query, $search) {

                        if(\Str::contains($attribute, '.')) {
                            list($relation, $field) = explode('.', $attribute);
                            $index === 0
                            ? $query->whereHas($relation, fn($query) => $query->whereLike($field, $search))
                            : $query->orWhereHas($relation, fn($query) => $query->whereLike($field, $search));
                        }
                        else {
                            $index === 0
                            ? $query->whereLike($attribute, $search)
                            : $query->orWhereLike($attribute, $search);
                        }

                    });
                    $query->when(is_callable($modifyQuery), function($query) use ($modifyQuery) {
                        return $modifyQuery($query);
                    });
                });
            });
        };
    }
}

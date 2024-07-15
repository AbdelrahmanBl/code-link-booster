<?php

namespace CodeLink\Booster\Traits;

trait HasBuilderFilter
{
    /**
     * Method to filter boolean columns.
     *
     * @param string $key [the filter key name]
     * @param string|null $attribute [the database field name]
     *
     * @return $this
     */
    public function booleanFilter($key, $attribute = null)
    {
        $attribute = $this->getAttributeKeyName($key, $attribute);

        return $this->when(in_array(request($key), ['1', '0']), function($query) use ($key, $attribute) {
            $query->where($attribute, (bool) request($key));
        });
    }

    /**
     * Method to filter columns by equal operator.
     *
     * @param string $key [the filter key name]
     * @param string|null $attribute [the database field name]
     *
     * @return $this
     */
    public function equalFilter($key, $attribute = null)
    {
        $attribute = $this->getAttributeKeyName($key, $attribute);

        return $this->when(request($key), function($query, $value) use ($attribute) {
            $query->where($attribute, $value);
        });
    }

    /**
     * Method to filter columns if soft deleted or not.
     *
     * @param string $key [the filter key name]
     * @param string $attribute [the database field name]
     *
     * @return $this
     */
    public function softDeletesFilter($key, $attribute = 'deleted_at')
    {
        return $this->when(in_array(request($key), ['1', '0']), function($query) use ($key, $attribute) {
            (bool) request($key)
            ? $query->whereNotNull($attribute)
            : $query->whereNull($attribute);
        });
    }

    /**
     * Method get the key name if the attribute is nullable.
     *
     * @param string $key [the filter key name]
     * @param string|null $attribute [the database field name]
     *
     * @return string
     */
    private function getAttributeKeyName($key, $attribute = null)
    {
        return is_null($attribute)
        ? $key
        : $attribute;
    }
}

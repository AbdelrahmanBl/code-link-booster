<?php

namespace CodeLink\Booster\Contracts;

/**
 * @template TKey of array-key
 * @template TValue
 */
interface StaticArrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public static function toArray(): array;
}

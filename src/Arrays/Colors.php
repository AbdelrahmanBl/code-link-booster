<?php

namespace CodeLink\Booster\Arrays;

class Colors extends DummyColors
{
    /**
     * Get the hexa of the green color...
     *
     * @return string
     */
    public static function green()
    {
        return parent::toArray()[0];
    }

    /**
     * Get the hexa of the red color...
     *
     * @return string
     */
    public static function red()
    {
        return parent::toArray()[1];
    }

    /**
     * Get the hexa of the yellow color...
     *
     * @return string
     */
    public static function yellow()
    {
        return parent::toArray()[2];
    }

    /**
     * Get the hexa of the black color...
     *
     * @return string
     */
    public static function black()
    {
        return parent::toArray()[16];
    }
}

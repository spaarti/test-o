<?php

namespace App\Helper;

trait SingletonTrait
{
    protected static $instance = null;

    /**
     * @return SingletonTrait
     */
    public static function getInstance(): self
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

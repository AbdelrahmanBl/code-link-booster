<?php

namespace CodeLink\Booster\Traits;

use CodeLink\Booster\Scopes\ActiveScope;

trait HasGlobalScopeActive
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasGlobalScopeActive()
    {
        static::addGlobalScope(new ActiveScope);
    }
}

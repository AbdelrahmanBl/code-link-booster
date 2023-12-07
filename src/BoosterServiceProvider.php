<?php

namespace CodeLink\Booster;

use CodeLink\Booster\Mixins\BuilderMixin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class BoosterServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Builder::mixin(new BuilderMixin);
    }
}

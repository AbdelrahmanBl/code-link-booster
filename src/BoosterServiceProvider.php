<?php

namespace CodeLink\Booster;

use CodeLink\Booster\Helpers\BoosterHelper;
use CodeLink\Booster\Mixins\BuilderMixin;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class BoosterServiceProvider extends ServiceProvider
{
    private string $configFile =  __DIR__ . '/Config/booster.php';

    private string $databaseDirectory = __DIR__ . '/Database';

    private array $migrationPaths = [];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // register booster helper for Booster facade..
        $this->app->bind('booster', fn() => new BoosterHelper);

        // register config file...
        $this->mergeConfigFrom($this->configFile, 'booster');

        // register migration for otps
        if(config('booster.services.otp_service.allow')) {
            $this->migrationPaths[] = $this->databaseDirectory . DIRECTORY_SEPARATOR . '2023_12_10_160549_create_otps_table.php';
        }

        // register migration paths...
        $this->loadMigrationsFrom($this->migrationPaths);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // register builder mixin...
        Builder::mixin(new BuilderMixin);

        // publish config file...
        $this->publishes([
            $this->configFile => config_path('booster.php'),
        ], 'booster');
    }
}

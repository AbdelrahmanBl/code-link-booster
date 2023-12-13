<?php

namespace CodeLink\Booster;

use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use CodeLink\Booster\Mixins\StringMixin;
use CodeLink\Booster\Mixins\BuilderMixin;
use Illuminate\Database\Eloquent\Builder;
use CodeLink\Booster\Helpers\BoosterHelper;

class BoosterServiceProvider extends ServiceProvider
{
    private string $configFile =  __DIR__ . '/Config/booster.php';

    private string $databaseDirectory = __DIR__ . '/Database';

    private string $viewsPath = __DIR__ . '/resources/views';

    private string $translationsPath = __DIR__ . '/resources/lang';

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

        // load views directory...
        $this->loadViewsFrom($this->viewsPath, 'booster');

        // load lang directory...
        $this->loadTranslationsFrom($this->translationsPath, 'booster');

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
        // register mixins...
        Builder::mixin(new BuilderMixin);
        Str::mixin(new StringMixin);

        // publish config file...
        $this->publishes([
            $this->configFile => config_path('booster.php'),
        ], 'booster-config');

        // publish views...
        $this->publishes([
            $this->viewsPath => resource_path('views/vendor/booster'),
        ], 'booster-views');

        // publish lang...
        $this->publishes([
            $this->translationsPath => lang_path('vendor/booster'),
        ], 'booster-lang');
    }
}

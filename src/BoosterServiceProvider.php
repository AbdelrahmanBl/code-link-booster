<?php

namespace CodeLink\Booster;

use CodeLink\Booster\Console\ArrayableMakeCommand;
use CodeLink\Booster\Console\ArrayExportMakeCommand;
use CodeLink\Booster\Console\BuilderMakeCommand;
use CodeLink\Booster\Console\EnumMakeCommand;
use CodeLink\Booster\Console\ReportMakeCommand;
use CodeLink\Booster\Console\TransformerMakeCommand;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use CodeLink\Booster\Mixins\StringMixin;
use CodeLink\Booster\Mixins\BuilderMixin;
use Illuminate\Database\Eloquent\Builder;
use CodeLink\Booster\Helpers\BoosterHelper;
use CodeLink\Booster\Mixins\AppMixin;
use CodeLink\Booster\Mixins\ArrayMixin;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;

class BoosterServiceProvider extends ServiceProvider
{
    private string $configFile =  __DIR__ . '/Config/booster.php';

    private string $databaseDirectory = __DIR__ . '/Database';

    private string $viewsPath = __DIR__ . '/resources/views';

    private string $translationsPath = __DIR__ . '/resources/lang';

    private string $stubsPath = __DIR__ . '/Console/stubs';

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

        // register commands...
        $this->commands([
            ReportMakeCommand::class,
            EnumMakeCommand::class,
            ArrayExportMakeCommand::class,
            ArrayableMakeCommand::class,
            TransformerMakeCommand::class,
            BuilderMakeCommand::class,
        ]);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // register mixins...
        Builder::mixin(new BuilderMixin);
        Str::mixin(new StringMixin);
        App::mixin(new AppMixin);
        Arr::mixin(new ArrayMixin);

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

        // publish stubs...
        $this->publishes([
            $this->stubsPath => base_path('stubs'),
        ], 'booster-stubs');
    }
}

<?php

namespace Code95\Page;

use Illuminate\Support\ServiceProvider;

class PageServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/pages.php' => config_path('pages.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../resources/views' => base_path('resources/views/admin/pages'),
            ], 'views');


            $this->publishes([
                __DIR__ . '/../resources/js/Page' => base_path('resources/js/view/pages'),
            ], 'views');


            $this->publishes([
                __DIR__ . '/../resources/js/components' => base_path('resources/js/backend/components'),
            ], 'views');


            $migrationFileName = 'create_pages_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }
            $migrationFileName = 'create_seo_table.php';
            if (! $this->migrationFileExists($migrationFileName)) {
                $this->publishes([
                    __DIR__ . "/../database/migrations/{$migrationFileName}.stub" => database_path('migrations/' . date('Y_m_d_His', time()) . '_' . $migrationFileName),
                ], 'migrations');
            }


            $this->loadRoutesFrom(__DIR__ . '/../src/route.php');
        }

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'pages');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/pages.php', 'pages');
    }

    public static function migrationFileExists(string $migrationFileName): bool
    {
        $len = strlen($migrationFileName);
        foreach (glob(database_path("migrations/*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName)) {
                return true;
            }
        }

        return false;
    }
}

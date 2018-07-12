<?php

namespace CrixuAMG\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     *
     */
    public function boot()
    {
        $this->loadTranslationsFrom(
            __DIR__ . '/resources/translations',
            'permissions'
        );

        // Register the commands
        // $this->registerCommands();
        // Allow the user to get the config file
        $this->registerConfiguration();
        // Allow the user to get the migration file
        $this->registerMigration();
    }

    /**
     * @throws \Throwable
     */
    public function register()
    {

    }

    /**
     * Register console commands
     */
    private function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                // TODO: add db:seed --class=CrixuAMG\Permissions\Database\Seeders\PermissionSeeder
            ]);
        }
    }

    /**
     * Register the config file
     */
    private function registerConfiguration()
    {
        $this->publishes([
            __DIR__ . '/config/permissions.php' => config_path('permissions.php'),
        ]);
    }

    /**
     * Register the config file
     */
    private function registerMigration()
    {
        if (!class_exists('CreatePermissionsTables')) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([
                __DIR__ . '/database/migrations/create_permissions_tables.php.stub' => $this->app->databasePath() . "/migrations/{$timestamp}_create_permissions_tables.php",
            ], 'migrations');
        }
    }
}

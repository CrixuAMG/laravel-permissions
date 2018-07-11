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
        // Register the commands
        // $this->registerCommands();
        // Allow the user to get the config file
        $this->registerConfiguration();
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
}

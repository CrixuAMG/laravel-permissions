<?php

namespace CrixuAMG\Permissions;

use CrixuAMG\Console\Commands\RolePermissionTableCommand;
use CrixuAMG\Permissions\Services\RoleDefiner;
use Illuminate\Support\ServiceProvider;

/**
 * Class PermissionServiceProvider
 * @package CrixuAMG\Permissions
 */
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

        $this->registerRoles();
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
                RolePermissionTableCommand::class,
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

    /**
     * Defines all registered roles as constants
     */
    private function registerRoles()
    {
        RoleDefiner::defineAll(config('permissions.role_pefix'));
    }
}

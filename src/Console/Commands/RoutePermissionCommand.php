<?php

namespace CrixuAMG\Permissions\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;

class RoutePermissionCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:route:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a table of all the roles with their allowed routes for an easy overview.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $routeCollection = Route::getRoutes();
        $roles           = config('permissions.models.roles')::with('permissions')
            ->groupBy('name')
            ->orderBy('id', 'ASC')
            ->get();
        $data            = [];
        $headers         = [
            '',
        ];
        $bar             = $this->output->createProgressBar(\count($routeCollection) * \count($roles));

        foreach ($roles as $role) {
            $headers[] = $role->name;
        }

        foreach ($routeCollection as $value) {
            $middlewares         = (array)$value->middleware();
            $addedPermissionData = false;
            $rowData             = [
                sprintf('%s (%s)', $value->uri, implode(', ', (array)$value->methods)),
            ];

            foreach ($middlewares as $middleware) {
                if (stripos($middleware, 'permission:') === false) {
                    continue;
                }

                $permissions = explode(',', str_after($middleware, 'permission:'));

                foreach ($roles as $role) {
                    $rowData[] = $role->hasAllPermissions($permissions)
                        ? 'yes'
                        : 'no';
                    $bar->advance();
                }

                $addedPermissionData = true;
            }

            if (!$addedPermissionData) {
                foreach ($roles as $role) {
                    $rowData[] = 'yes';
                    $bar->advance();
                }
            }

            $data[] = $rowData;
        }

        $bar->finish();
        $this->info(PHP_EOL);
        $this->table($headers, $data);
    }
}

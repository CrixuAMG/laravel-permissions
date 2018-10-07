<?php

namespace CrixuAMG\Permissions\Console\Commands;

use Illuminate\Console\Command;

class RolePermissionTableCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:permission:table';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a table of all the roles with their permissions for an easy overview.';

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
        $roles       = config('permissions.models.roles')::with('permissions')->get();
        $permissions = config('permissions.models.permissions')::all();
        $headers     = [
            '',
        ];
        $data        = [];
        foreach ($roles as $role) {
            $headers[] = $role->name;
        }
        foreach ($permissions as $index => $permission) {
            $rowData = [
                $permission->name,
            ];
            foreach ($roles as $role) {
                $rowData[] = $role->permissions->contains('name', $permission->name)
                    ? 'yes'
                    : 'no';
            }
            $data[$index] = $rowData;
        }
        $this->table($headers, $data);
    }
}

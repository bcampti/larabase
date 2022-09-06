<?php

namespace Bcampti\Larabase\Presets\Traits;

use Illuminate\Filesystem\Filesystem;

trait MigrationCommandTrait
{
    use HandleFiles;
    
    private function publishMigrations():self
    {
        (new Filesystem)->ensureDirectoryExists(database_path('factories'));
        (new Filesystem)->ensureDirectoryExists(database_path('migrations'));
        (new Filesystem)->ensureDirectoryExists(database_path('migrations/landlord'));
        (new Filesystem)->ensureDirectoryExists(database_path('migrations/tenant'));

        $files = [
            'database/migrations/landlord/2014_10_12_000000_create_users_table.php',
            'database/migrations/landlord/2014_10_12_100000_create_password_resets_table.php',
            'database/migrations/landlord/2019_08_19_000000_create_failed_jobs_table.php',
            'database/migrations/landlord/2022_09_01_170342_create_account_tenants_table.php',
            'database/migrations/landlord/2022_09_01_171049_create_audits_table.php',
            'database/migrations/landlord/2022_09_01_172625_add_custom_field_to_users_table.php',
            
            'database/migrations/tenant/2022_09_01_000000_create_usuario_table.php',
            'database/migrations/tenant/2022_09_01_172625_add_custom_field_to_usuario_table.php',
            'database/migrations/tenant/2022_09_01_173049_create_organizacao_table.php',
            'database/migrations/tenant/2022_09_01_193049_create_audits_table.php'
        ];

        foreach ($files as $file) {
            $publishPath = base_path($file);

            $overwrite = true;

            /* if (file_exists($publishPath)) {
                $overwrite = $this->confirm(
                    "<fg=red>{$file} already exists.</fg=red>\n " .
                        'Do you want to overwrite?',
                    false
                );
            } */

            if (!file_exists($publishPath) || $overwrite) {
                copy(__DIR__ . '/../../../' . $file, $publishPath);
            }
        }

        return $this;
    }
    
}

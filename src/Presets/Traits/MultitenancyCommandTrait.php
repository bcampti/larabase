<?php

namespace Bcampti\Larabase\Presets\Traits;

trait MultitenancyCommandTrait
{
    use HandleFiles;

    private function publishMultitenancy():self
    {
        $params = [
            '--provider' => "Spatie\Multitenancy\MultitenancyServiceProvider",
            '--tag' => "multitenancy-config"
        ];

        $execute = true;
        $fileName = 'multitenancy.php';
        $params['--force'] = true;
        /* if( $this->exists(config_path($fileName)) ){
            if( $this->shouldOverwriteFile($fileName) ){
                $params['--force'] = true;
            } else {
                $execute = false;
            }
        } */

        $this->ensureDirectoryExists(app_path('Multitenancy/Tasks'));

        if( $execute == true ){
            $this->call('vendor:publish', $params);

            $this->publishFiles([
                'config/database.php',
                'config/multitenancy.php',
                'app/Multitenancy/Tasks/SwitchTenantDatabaseTask.php'
            ]);
        }

        /* $params = [
            '--provider' => "Spatie\Multitenancy\MultitenancyServiceProvider",
            '--tag' => "multitenancy-migrations"
        ];

        $this->call('vendor:publish', $params); */

        return $this;
    }

}

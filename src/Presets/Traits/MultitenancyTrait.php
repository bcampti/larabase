<?php

namespace Bcampti\Larabase\Presets\Traits;

trait MultitenancyTrait
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
        if( $this->exists(config_path($fileName)) ){
            if( $this->shouldOverwriteFile($fileName) ){
                $params['--force'] = true;
            } else {
                $execute = false;
            }
        }

        $this->ensureDirectoryExists(app_path('Multitenancy/Tasks'));

        if( $execute == true ){
            $this->call('vendor:publish', $params);

            $this->copyOrOverwreteFile('config/database.php');
            $this->copyOrOverwreteFile('config/multitenancy.php');
            $this->copyOrOverwreteFile('app/Multitenancy/Tasks/SwitchTenantDatabaseTask.php');
        }

        $params = [
            '--provider' => "Spatie\Multitenancy\MultitenancyServiceProvider",
            '--tag' => "multitenancy-migrations"
        ];

        $this->call('vendor:publish', $params);

        return $this;
    }

}

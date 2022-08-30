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

        if( $execute == true ){
            $this->call('vendor:publish', $params);

            $this->copyOrOverwreteFile('config/multitenancy.php');
        }

        $params = [
            '--provider' => "Spatie\Multitenancy\MultitenancyServiceProvider",
            '--tag' => "multitenancy-migrations"
        ];

        $this->call('vendor:publish', $params);

        return $this;
    }

}

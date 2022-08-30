<?php

namespace Bcampti\Larabase\Presets\Traits;

trait MultitenancyTrait
{
    use HandleFiles;

    private function publishMultitenancy($forcePublish = true):self
    {
        $params = [
            '--provider' => "Spatie\Multitenancy\MultitenancyServiceProvider",
            '--tag' => "multitenancy-config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);

        $params = [
            '--provider' => "Spatie\Multitenancy\MultitenancyServiceProvider",
            '--tag' => "multitenancy-migrations"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);

        return $this;
    }

}

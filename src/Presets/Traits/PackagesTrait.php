<?php

namespace Bcampti\Larabase\Presets\Traits;

use Illuminate\Support\Facades\File;

trait PackagesTrait
{
    use HandleFiles;

    public function publishPackages(): self
    {
        $this->info('Publishing packages Spatie\Multitenancy ...');

        $fileName = "multitenancy.php";
        if (!$this->configExists($fileName)) {
            $this->publishMultitenancy();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig($fileName)) {
                $this->info('Overwriting configuration file...');
                $this->publishMultitenancy($force = true);
            } else {
                $this->info('Existing configuration was not overwritten.[{$fileName}]');
            }
        }

        $this->info('Publishing packages OwenIt\Auditing ...');
        $fileName = "audit.php";
        if (!$this->configExists($fileName)) {
            $this->publishAudit();
            $this->info('Published configuration');
        } else {
            if ($this->shouldOverwriteConfig($fileName)) {
                $this->info('Overwriting configuration file...');
                $this->publishAudit($force = true);
            } else {
                $this->info('Existing configuration was not overwritten.[{$fileName}]');
            }
        }

        return $this;
    }

    private function configExists($fileName)
    {
        return File::exists(config_path($fileName));
    }

    private function shouldOverwriteConfig($fileName)
    {
        return $this->confirm(
            'Config {$fileName} file already exists. Do you want to overwrite it?',
            false
        );
    }

    private function publishMultitenancy($forcePublish = false)
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
    }

    private function publishAudit($forcePublish = false)
    {
        $params = [
            '--provider' => "OwenIt\Auditing\AuditingServiceProvider",
            '--tag' => "config"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);

        $params = [
            '--provider' => "OwenIt\Auditing\AuditingServiceProvider",
            '--tag' => "migrations"
        ];

        if ($forcePublish === true) {
            $params['--force'] = true;
        }

        $this->call('vendor:publish', $params);
    }
    
}

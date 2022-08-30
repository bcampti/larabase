<?php

namespace Bcampti\Larabase\Presets\Traits;

trait AuditTrait
{
    use HandleFiles;
    
    private function publishAudit($forcePublish = true):self
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

        $files = [
            'config/audit.php',
        ];

        $this->publishFiles($files);

        return $this;
    }
    
}

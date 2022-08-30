<?php

namespace Bcampti\Larabase\Presets\Traits;

trait AuditTrait
{
    use HandleFiles;
    
    private function publishAudit():self
    {
        $params = [
            '--provider' => "OwenIt\Auditing\AuditingServiceProvider",
            '--tag' => "config"
        ];

        $execute = true;
        $fileName = 'audit.php';
        if( $this->exists(config_path($fileName)) ){
            if( $this->shouldOverwriteFile($fileName) ){
                $params['--force'] = true;
            } else {
                $execute = false;
            }
        }

        if( $execute == true ){
            $this->call('vendor:publish', $params);

            $this->copyOrOverwreteFile('config/audit.php');
        }

        $params = [
            '--provider' => "OwenIt\Auditing\AuditingServiceProvider",
            '--tag' => "migrations"
        ];

        $this->call('vendor:publish', $params);

        
        return $this;
    }
    
}

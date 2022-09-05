<?php

namespace Bcampti\Larabase\Presets\Traits;

trait TranslateCommandTrait
{
    use HandleFiles;
    
    private function publishTranslate():self
    {
        $params = [
            '--provider' => "lucascudo/laravel-pt-br-localization",
            '--dev' => "true"
        ];

        $execute = true;
        $params['--force'] = true;
        /* if( $this->exists(config_path($fileName)) ){
            if( $this->shouldOverwriteFile($fileName) ){
                $params['--force'] = true;
            } else {
                $execute = false;
            }
        } */

        if( $execute == true ){
            $this->call('vendor:publish', $params);
        }

        return $this;
    }
    
}

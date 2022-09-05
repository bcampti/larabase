<?php

namespace Bcampti\Larabase\Presets\Traits;

trait TranslateCommandTrait
{
    use HandleFiles;
    
    private function publishTranslate():self
    {
        $params = [
            '--tag' => "laravel-pt-br-localization"
        ];

        $this->call('vendor:publish', $params);

        return $this;
    }
    
}

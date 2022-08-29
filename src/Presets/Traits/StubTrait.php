<?php

namespace Bcampti\Larabase\Presets\Traits;

trait StubTrait
{
    public function stubPath(string $file): string
    {
        return __DIR__.'/../../../stubs/Presets/'.$file;
    }

    public function publishFiles(array $files)
    {
        foreach ($files as $file) {
            $publishPath = base_path($file);

            $overwrite = false;

            if (file_exists($publishPath)) {
                $overwrite = $this->confirm(
                    "<fg=red>{$file} already exists.</fg=red>\n ".
                    'Do you want to overwrite?',
                    false
                );
            }

            if (! file_exists($publishPath) || $overwrite) {
                copy(
                    __DIR__.'/../../../stubs/'.$file,
                    $publishPath
                );
            }
        }
    }

}
<?php

namespace Bcampti\Larabase\Presets\Traits;

trait StubTrait
{
    public function stubPath(string $file): string
    {
        return __DIR__.'/../../../stubs/Presets/'.$file;
    }
}
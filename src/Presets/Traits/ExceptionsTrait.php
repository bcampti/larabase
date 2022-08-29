<?php

namespace Bcampti\Larabase\Presets\Traits;

trait ExceptionsTrait
{
    use HandleFiles;
    use StubTrait;

    public function exportExceptions(): self
    {
        $this->ensureDirectoryExists(app_path('Scopes'));

        $scopes = [
            'app/Exceptions/GenericMessage.php',
            'app/Exceptions/Handler.php',
        ];

        $this->publishFiles($scopes);

        return $this;
    }

}

<?php

namespace Bcampti\Larabase\Presets\Traits;

/* use Qirolab\Theme\Enums\CssFramework;
use Qirolab\Theme\Enums\JsFramework;
use Qirolab\Theme\Theme; */

trait ScopesTrait
{
    use HandleFiles;
    use StubTrait;

    public function exportScopes(): self
    {
        $this->ensureDirectoryExists(app_path('Scopes'));

        $scopes = [
            'app/Scopes/OrganizacaoScope.php',
        ];

        $this->publishFiles($scopes);

        return $this;
    }

}

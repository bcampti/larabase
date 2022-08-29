<?php

namespace Bcampti\Larabase\Presets\Traits;

trait ModelTrait
{
    use HandleFiles;
    use StubTrait;

    public function exportModelScaffolding(): void
    {
        $this->exportScopes();
    }
    
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

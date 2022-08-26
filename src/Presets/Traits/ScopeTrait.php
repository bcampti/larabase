<?php

namespace Bcampti\Larabase\Presets\Traits;

/* use Qirolab\Theme\Enums\CssFramework;
use Qirolab\Theme\Enums\JsFramework;
use Qirolab\Theme\Theme; */

trait ScopeTrait
{
    use HandleFiles;
    use StubTrait;

    public function exportScopes(): self
    {
        $this->ensureDirectoryExists(app_path('Scopes'));

        $controllers = [
            'app/Scopes/OrganizacaoScope.php',
        ];

        $this->publishFilesScopes($controllers);

        return $this;
    }

    protected function publishFilesScopes(array $files): void
    {
        foreach ($files as $file) {
            $publishPath = base_path($file);

            $overwrite = false;

            if (file_exists($publishPath)) {
                $overwrite = $this->confirm(
                    "<fg=red>{$file} already exists.</fg=red>\n " .
                        'Do you want to overwrite?',
                    false
                );
            }

            if (!file_exists($publishPath) || $overwrite) {
                copy(
                    __DIR__ . '/../../../stubs/' . $file,
                    $publishPath
                );
            }
        }
    }
}

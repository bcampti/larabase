<?php

namespace Bcampti\Larabase\Presets\Traits;

use Illuminate\Filesystem\Filesystem;

trait HandleFiles
{
    /**
     * Ensure a directory exists.
     *
     * @param  string $path
     * @param  int    $mode
     * @param  bool   $recursive
     * @return void
     */
    protected function ensureDirectoryExists(string $path, int $mode = 0755, bool $recursive = true)
    {
        if (!(new Filesystem())->isDirectory($path)) {
            (new Filesystem())->makeDirectory($path, $mode, $recursive);
        }
    }

    protected function replaceInFile(string $search, string $replace, string $path): int|bool
    {
        return file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    public function createFile(string $path, string $content = ''): int|bool
    {
        return file_put_contents($path, $content);
    }

    public function append(string $path, string $data): int|bool
    {
        return file_put_contents($path, $data, FILE_APPEND);
    }

    public function copyDirectory(string $directory, string $destination, int | null $options = null): bool
    {
        return (new Filesystem())->copyDirectory($directory, $destination, $options);
    }

    public function exists(string $path): bool
    {
        return file_exists($path);
    }

    private function shouldOverwriteFile($fileName)
    {
        return $this->confirm(
            "'{$fileName}' file already exists. Do you want to overwrite it?",
            false
        );
    }

    public function publishFiles(array $files)
    {
        foreach ($files as $file) {
            $publishPath = base_path($file);

            $overwrite = true;

            /* if (file_exists($publishPath)) {
                $overwrite = $this->confirm(
                    "<fg=red>{$file} already exists.</fg=red>\n " .
                        'Do you want to overwrite?',
                    false
                );
            } */

            if (!file_exists($publishPath) || $overwrite) {
                copy(__DIR__ . '/../../../stubs/' . $file, $publishPath);
            }
        }
    }

}

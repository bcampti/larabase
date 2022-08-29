<?php

namespace Bcampti\Larabase\Commands;

use Bcampti\Larabase\Presets\Traits\ExceptionsTrait;
use Bcampti\Larabase\Presets\Traits\ModelTrait;
use Bcampti\Larabase\Presets\Traits\PackagesTrait;
use Bcampti\Larabase\Presets\Traits\StubTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LarabaseInstallerCommand extends Command
{
    use PackagesTrait, ExceptionsTrait, ModelTrait;
    //use AuthTrait;
    use StubTrait;
    
    public $signature = 'larabase:install';

    public $description = 'Instala a configuração inicial e de login para multi-tenancy';

    public function handle(): void
    {
        /* $authScaffolding = $this->askAuthScaffolding();

        $this->exportAuthScaffolding($authScaffolding);

        $this->line("<options=bold>Auth Scaffolding:</options=bold> {$authScaffolding}");
        $this->line(''); */

        $this->publishPackages();
        
        $this->exportExceptions();
        $this->exportModelScaffolding();

        $this->info('Installed Larabase package');
    }

    public function askAuthScaffolding()
    {
        $options = [
            'Views Only',
            'Controllers & Views',
            'Skip',
        ];

        $authScaffolding = $this->choice(
            'Publish Auth Scaffolding',
            $options,
            $_default = $options[0],
            $_maxAttempts = null,
            $_allowMultipleSelections = false
        );

        return $authScaffolding;
    }

    protected function askValid(string $question, string $field, array $rules)
    {
        $value = $this->ask($question);

        if ($message = $this->validateInput($rules, $field, $value)) {
            $this->error($message);

            return $this->askValid($question, $field, $rules);
        }

        return $value;
    }

    protected function validateInput($rules, $fieldName, $value): ?string
    {
        $validator = Validator::make([
            $fieldName => $value,
        ], [
            $fieldName => $rules,
        ]);

        return $validator->fails()
            ? $validator->errors()->first($fieldName)
            : null;
    }
}

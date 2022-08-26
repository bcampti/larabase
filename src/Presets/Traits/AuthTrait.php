<?php

namespace Bcampti\Larabase\Presets\Traits;

/* use Qirolab\Theme\Enums\CssFramework;
use Qirolab\Theme\Enums\JsFramework;
use Qirolab\Theme\Theme; */

trait AuthTrait
{
    use HandleFiles;
    use StubTrait;

    public function exportAuthTrait(string $authTrait = 'Views Only'): void
    {
        if ($authTrait == 'Controllers & Views') {
            $this->exportControllers()
                ->exportComponents()
                ->exportRequests()
                ->exportViews()
                ->exportRoutes()
                ->exportTests();
        }

        if ($authTrait == 'Views Only') {
            $this->exportViews();
        }
    }

    public function exportControllers(): self
    {
        $this->ensureDirectoryExists(app_path('Http/Controllers/Auth'));

        $controllers = [
            'app/Http/Controllers/Auth/AuthenticatedSessionController.php',
            'app/Http/Controllers/Auth/ConfirmablePasswordController.php',
            'app/Http/Controllers/Auth/EmailVerificationNotificationController.php',
            'app/Http/Controllers/Auth/EmailVerificationPromptController.php',
            'app/Http/Controllers/Auth/NewPasswordController.php',
            'app/Http/Controllers/Auth/PasswordResetLinkController.php',
            'app/Http/Controllers/Auth/RegisteredUserController.php',
            'app/Http/Controllers/Auth/VerifyEmailController.php',
        ];

        $this->publishFiles($controllers);

        return $this;
    }

    public function exportComponents(): self
    {
        $this->ensureDirectoryExists(app_path('View/Components'));

        $components = [
            'app/View/Components/AppLayout.php',
            'app/View/Components/GuestLayout.php',
        ];

        $this->publishFiles($components);

        return $this;
    }

    protected function exportRequests(): self
    {
        $this->ensureDirectoryExists(app_path('Http/Requests/Auth'));

        $files = [
            'app/Http/Requests/Auth/LoginRequest.php',
        ];

        $this->publishFiles($files);

        return $this;
    }

    public function exportViews(): self
    {
        $this->ensureDirectoryExists(resource_path('views'));

        $this->copyDirectory(
            __DIR__."/../../../stubs/resources/{$this->cssFramework}/views",
            resource_path('views')
        );

        $themePath = $this->relativeThemePath($this->theme);

        /* $cssPath = $themePath.($this->cssFramework === CssFramework::Bootstrap ? '/sass/app.scss' : '/css/app.css');
        $jsPath = $themePath.'/js/app.js';
        $viteConfig = "@vite(['".$cssPath."', '".$jsPath."'])";

        if ($this->jsFramework === JsFramework::React) {
            $viteConfig = '@viteReactRefresh'."\n    ".$viteConfig;
        }

        $this->replaceInFile('%vite%', $viteConfig, Theme::path('views/layouts/app.blade.php', $this->theme));
        $this->replaceInFile('%vite%', $viteConfig, Theme::path('views/layouts/guest.blade.php', $this->theme));
 */
        return $this;
    }

    public function exportRoutes(): self
    {
        $routeFile = 'routes/auth.php';

        $overwrite = false;

        if (file_exists(base_path($routeFile))) {
            $overwrite = $this->confirm(
                "<fg=red>{$routeFile} already exists.</fg=red>\n ".
                    'Do you want to overwrite?',
                false
            );
        }

        if (! file_exists(base_path($routeFile)) || $overwrite) {
            copy(__DIR__.'/../../../stubs/routes/auth.php', base_path('routes/auth.php'));

            $homeRoute = "

Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

";
            $requireAuth = "require __DIR__.'/auth.php';";

            if (! exec('grep '.escapeshellarg($requireAuth).' '.base_path('routes/web.php'))) {
                $this->append(
                    base_path('routes/web.php'),
                    $homeRoute.$requireAuth
                );
            }
        }

        return $this;
    }

    public function exportTests(): self
    {
        $this->ensureDirectoryExists(base_path('tests/Feature'));

        $testFiles = [
            'tests/Feature/AuthenticationTest.php',
            'tests/Feature/EmailVerificationTest.php',
            'tests/Feature/PasswordConfirmationTest.php',
            'tests/Feature/PasswordResetTest.php',
            'tests/Feature/RegistrationTest.php',
        ];

        $this->publishFiles($testFiles);

        return $this;
    }

    protected function publishFiles(array $files): void
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
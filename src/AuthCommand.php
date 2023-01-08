<?php

namespace Jefter\Ui;

use Illuminate\Console\Command;
use InvalidArgumentException;

class AuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ui:auth
                    { type=bootstrap : The preset type (bootstrap) }
                    {--views : Only scaffold the authentication views}
                    {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic login and registration views and routes';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'auth/login.stub' => 'auth/login.blade.php',
        'auth/passwords/confirm.stub' => 'auth/passwords/confirm.blade.php',
        'auth/passwords/email.stub' => 'auth/passwords/email.blade.php',
        'auth/passwords/reset.stub' => 'auth/passwords/reset.blade.php',
        'auth/register.stub' => 'auth/register.blade.php',
        'auth/verify.stub' => 'auth/verify.blade.php',
        'home.stub' => 'home.blade.php',
        'layouts/app.stub' => 'layouts/app.blade.php',
        'layouts/appVue.stub' => 'layouts/appVue.blade.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     *
     * @throws \InvalidArgumentException
     */
    public function handle()
    {
        if (static::hasMacro($this->argument('type'))) {
            return call_user_func(static::$macros[$this->argument('type')], $this);
        }

        if (!in_array($this->argument('type'), ['bootstrap'])) {
            throw new InvalidArgumentException('Invalid preset.');
        }

        $this->ensureDirectoriesExist();
        $this->exportViews();

        if (!$this->option('views')) {
            $this->exportBackend();
        }

        $this->components->info('Authentication scaffolding generated successfully.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureDirectoriesExist()
    {
        if (!is_dir($directory = $this->getViewPath('layouts'))) {
            mkdir($directory, 0755, true);
        }

        if (!is_dir($directory = $this->getViewPath('auth/passwords'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = $this->getViewPath($value)) && !$this->option('force')) {
                if (!$this->components->confirm("The [$value] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(
                __DIR__ . '/Auth/' . $this->argument('type') . '-stubs/' . $key,
                $view
            );
        }
    }

    /**
     * Export the authentication backend.
     *
     * @return void
     */
    protected function exportBackend()
    {
        $this->callSilent('ui:controllers');

        $controller = app_path('Http/Controllers/HomeController.php');

        if (file_exists($controller) && !$this->option('force')) {
            if ($this->components->confirm("The [HomeController.php] file already exists. Do you want to replace it?")) {
                file_put_contents($controller, $this->compileControllerStub());
            }
        } else {
            file_put_contents($controller, $this->compileControllerStub());
        }

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__ . '/Auth/stubs/routes.stub'),
            FILE_APPEND
        );

        copy(
            __DIR__ . '/../stubs/migrations/2014_10_12_100000_create_password_resets_table.php',
            base_path('database/migrations/2014_10_12_100000_create_password_resets_table.php')
        );



        if (file_exists(base_path("database/migrations/2014_10_12_000000_create_users_table.php")) == true) {
            unlink(base_path("database/migrations/2014_10_12_000000_create_users_table.php"));
            copy(
                __DIR__ . '/../stubs/migrations/2014_10_12_000000_create_users_table.php',
                base_path('database/migrations/2014_10_12_000000_create_users_table.php')
            );
        } else {
            copy(
                __DIR__ . '/../stubs/migrations/2014_10_12_000000_create_users_table.php',
                base_path('database/migrations/2014_10_12_000000_create_users_table.php')
            );
        }
        copy(
            __DIR__ . '/../stubs/migrations/2014_10_12_000000_create_users_table.php',
            base_path('database/migrations/2014_10_12_000000_create_users_table.php')
        );
        /****
         * new
         ****/
        echo "vaiiii";
        if (file_exists(base_path("vendor\\laravel\\framework\src\Illuminate\Support\Facades\auth.php")) == true) {
            unlink(base_path("vendor\\laravel\\framework\src\Illuminate\Support\Facades\auth.php"));
            copy(__DIR__ . "/../stubs/Laravel-framework/auth.stub", base_path("vendor\\laravel\\framework\src\Illuminate\Support\Facades\auth.php"));
        } else {
            copy(__DIR__ . "/../stubs/Laravel-framework/auth.stub", base_path("vendor\\laravel\\framework\src\Illuminate\Support\Facades\auth.php"));
        }
        if (file_exists(app_path('Helpers\Pcrypt.php'))) {
            unlink(app_path('Helpers/Pcrypt.php'));
            copy(
                __DIR__ . '/../stubs/Helpers/Pcrypt.stub',
                app_path('Helpers/Pcrypt.php')
            );
        } elseif (!file_exists(app_path('Helpers'))) {
            mkdir(app_path('Helpers'), 0755, true);
            copy(
                __DIR__ . '/../stubs/Helpers/Pcrypt.stub',
                app_path('Helpers/Pcrypt.php')
            );
        } else {
            copy(
                __DIR__ . '/../stubs/Helpers/Pcrypt.stub',
                app_path('Helpers/Pcrypt.php')
            );
        }

        if (file_exists(resource_path('js/Views/auth/login.vue'))) {
            unlink(resource_path('js/views/auth/login.vue'));
            copy(
                __DIR__ . '/vue-stubs/Views/auth/login.vue',
                resource_path('js/Views/auth/login.vue')
            );
        } elseif (!file_exists(app_path('js/Views/auth'))) {
            mkdir(app_path('Views/auth'), 0755, true);
             copy(
                __DIR__ . '/vue-stubs/Views/auth/login.vue',
                resource_path('js/Views/auth/login.vue')
            );
        } else {
             copy(
                __DIR__ . '/vue-stubs/Views/auth/login.vue',
                resource_path('js/Views/auth/login.vue')
            );
        }
    }


    /**
     * Compiles the "HomeController" stub.
     *
     * @return string
     */
    protected function compileControllerStub()
    {
        return str_replace(
            '{{namespace}}',
            $this->laravel->getNamespace(),
            file_get_contents(__DIR__ . '/Auth/stubs/controllers/HomeController.stub')
        );
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param  string  $path
     * @return string
     */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }
}

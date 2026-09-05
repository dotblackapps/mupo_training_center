<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use SpondonIt\LmsService\Repositories\InitRepository;
use Throwable;

class GeneralSettingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {



        $this->app->singleton('ModuleList', function () {
            return Cache::rememberForever('ModuleList', function () {
               return DB::table('modules')->select('name', 'status', 'order', 'details')->get();
            });
        });



        $this->app->singleton('ModulePackageList', function () {
            return \Nwidart\Modules\Facades\Module::all();
        });

        $this->app->singleton('ModuleManagerList', function () {
            return Cache::rememberForever('ModuleManagerList', function () {
                return DB::table('infix_module_managers')
                    ->select('name', 'email', 'notes', 'version', 'update_url', 'purchase_code', 'installed_domain', 'activated_date', 'checksum')
                    ->get();
            });
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->ensureGeneralSettingsAreBound();
    }

    /**
     * Guarantee that the 'getSetting' container binding used by the
     * Settings() helper is populated before any controller/view code runs.
     *
     * Background: SpondonIt\LmsService\Repositories\InitRepository::init()
     * is expected to register the 'getSetting' binding during the LMS
     * package's own boot cycle, but in practice it does not reliably do so
     * on every request (app()->bound('getSetting') can still be false after
     * the framework has finished booting). When application code later
     * resolves app('getSetting') for the first time, the package resolves
     * it lazily and, on some requests, blows up with a PHP TypeError
     * (array_keys(): Argument #1 ($array) must be of type array, null
     * given) instead of returning the settings array. Because a TypeError
     * extends \Error (not \Exception), it is not caught by the
     * `catch (Exception $e)` blocks used throughout the app's helpers and
     * controllers, so it surfaces as an uncaught 500 error.
     *
     * InitRepository::config() reliably (re)builds and registers the same
     * 'getSetting' binding, so we call it once here, at the very end of the
     * framework's provider boot cycle (App\Providers\* boot() methods run
     * after package-discovered providers, including SpondonItLmsServiceProvider),
     * but only if the package has not already bound it successfully. This
     * keeps the fix additive and idempotent:
     *  - If the package already bound 'getSetting' correctly, we do nothing.
     *  - If it did not, we bind it ourselves before any controller/view can
     *    resolve it, removing the request-order dependency that caused the
     *    intermittent 500s on the course details page and the admin course
     *    DataTable.
     *  - If, for any reason, InitRepository::config() itself fails, we log
     *    the failure and fall back to binding an empty settings array so
     *    that `app('getSetting')[$key]` degrades to `null` instead of
     *    throwing and taking down the whole page.
     */
    protected function ensureGeneralSettingsAreBound(): void
    {
        if ($this->app->bound('getSetting')) {
            return;
        }

        try {
            $this->app->make(InitRepository::class)->config();
        } catch (Throwable $e) {
            Log::error('GeneralSettingsServiceProvider: failed to initialize general settings via InitRepository::config().', [
                'exception' => $e->getMessage(),
            ]);
        }

        if (!$this->app->bound('getSetting')) {
            // Last-resort safety net so Settings()/app('getSetting')[$key]
            // never fatals with a TypeError further down the stack.
            $this->app->singleton('getSetting', function () {
                return [];
            });
        }
    }
}

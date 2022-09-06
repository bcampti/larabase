<?php
namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Blade;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        Audit::creating(function (Audit $model) {
            if (empty($model->old_values) && empty($model->new_values)) {
                return false;
            }
        });
        Audit::updating(function (Audit $model) {
            if (empty($model->old_values) && empty($model->new_values)) {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if( config("larabase.debug_query") ){
    	    DB::listen(function($query){
                Log::info("\n---------------------------------------------------------------"
                    ."\nSchema=[".$query->connection->getConfig()['schema']."] - TEMPO[".$query->time."]"
                    ."\nQUERY[". Str::replaceArray('?', $query->bindings, $query->sql) ."]"
                );
            });
        }

        Model::preventLazyLoading(!app()->isProduction());

        Blade::if('havePermission', function ($permissao) {
            if( auth()->user()->tipo==User::TIPO_SUPORTE )return true;
            if( auth()->user()->tipo==$permissao )return true;
            return false;
        });

        Blade::directive('moneyFormat', function ($valor) {
            return "<?php echo 'R$ ' . number_format($valor, 2, ',', '.'); ?>";
        });
    }
}

<?php
namespace App\Providers;

use App\Models\User;
use Bcampti\Larabase\Enums\CargoUsuarioEnum;
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
                    ."\nSchema=[".$query->connection->getConfig()['search_path']."] - TEMPO[".$query->time."]"
                    ."\nQUERY[". Str::replaceArray('?', $query->bindings, $query->sql) ."]"
                );
            });
        }

        Model::preventLazyLoading(!app()->isProduction());

        Blade::if('hasPermission', function ($permissao) {
            if( CargoUsuarioEnum::SUPORTE->equals(auth()->user()->cargo) ){
                return true;
            }
            if( is_array($permissao) ){
                return in_array(auth()->user()->cargo, $permissao);
            }else{
                if( auth()->user()->cargo==$permissao ){
                    return true;
                }
            }
            return false;
        });
        Blade::if('hasSuporte', function () {
            return CargoUsuarioEnum::SUPORTE->equals(auth()->user()->cargo);
        });
        Blade::if('hasProprietario', function () {
            return CargoUsuarioEnum::PROPRIETARIO->equals(auth()->user()->cargo) || CargoUsuarioEnum::SUPORTE->equals(auth()->user()->cargo);
        });
        Blade::if('hasProprietario', function () {
            return CargoUsuarioEnum::ADMIN->equals(auth()->user()->cargo) || CargoUsuarioEnum::PROPRIETARIO->equals(auth()->user()->cargo) || CargoUsuarioEnum::SUPORTE->equals(auth()->user()->cargo);
        });

        Blade::directive('moneyFormat', function ($valor) {
            return "<?php echo 'R$ ' . number_format($valor, 2, ',', '.'); ?>";
        });
    }
}

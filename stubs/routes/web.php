<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('sair', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('sair');

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    
    return back()->with('resent', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');

Route::get('/email/verify/{id}/{hash}', function (Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    (new Bcampti\Larabase\Actions\Account\ActiveAccount)->execute($request->user());
    return redirect(route('home'));
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::middleware(['auth','verified'])->group(function()
{
    Route::prefix('auth')->group(function(){
        Route::get(	'/account/select/{id}', [\App\Http\Controllers\Auth\LoginController::class, 'accountSelect'] )->name('auth.account.select');
        Route::get('/account/none', [\App\Http\Controllers\Auth\LoginController::class, 'accountNoDatabase'])->name('auth.account.no.database');

        Route::middleware(['tenant'])->group(function()
        {
            Route::match(['get','post'], 'account/organizacao', [\App\Http\Controllers\Auth\LoginController::class,'organizacoes'] )->name('auth.account.organizacao.index');
            Route::get(	'account/organizacao/select/{id}', [\App\Http\Controllers\Auth\LoginController::class, 'organizacaoSelect'] )->name('auth.account.organizacao.select');

            Route::prefix('organizacao')->group(function(){
                Route::match(['get','post'], '/', [OrganizacaoController::class, 'index'])->name('organizacao.index');
                Route::get('cadastrar', [OrganizacaoController::class, 'create'])->name('organizacao.create');
                Route::post('salvar', [OrganizacaoController::class, 'store'])->name('organizacao.store');
                Route::get('alterar/{id}', [OrganizacaoController::class, 'edit'])->name('organizacao.edit');
                Route::put('update/{id}', [OrganizacaoController::class, 'update'])->name('organizacao.update');
                Route::delete('excluir/{id}', [OrganizacaoController::class, 'destroy'])->name('organizacao.destroy');
            });
        });
    });

    // Utilizado para limpar da sessao o filtro aplicado na consulta das listagens
    Route::get('/limpar/filtro', function(){
        session()->forget('filtro');
        return back();
    })->name('limpar.filtro');
    
    Route::middleware(['tenant'])->group(function()
    {
        Route::middleware(['checkOrganizacao'])->group(function()
        {
            Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

            Route::prefix('perfil')->group(function(){
                Route::get('/', [App\Http\Controllers\Tenant\UsuarioController::class, 'perfil'])->name('usuario.perfil');
                Route::post('update', [App\Http\Controllers\Tenant\UsuarioController::class, 'update'])->name('usuario.perfil.update');
                Route::post('update/password', [App\Http\Controllers\Tenant\UsuarioController::class, 'updatePassword'])->name('usuario.perfil.update.password');
            });
        });

    });

});
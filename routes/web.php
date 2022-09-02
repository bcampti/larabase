<?php

use Bcampti\Larabase\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->group(function(){
    Route::match(['get','post'], '/', [AccountController::class, 'index'])->name('account.index');
    Route::get('cadastrar', [AccountController::class, 'create'])->name('account.create');
    Route::post('salvar', [AccountController::class, 'store'])->name('account.store');
    Route::get('alterar/{id}', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('update/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('excluir/{id}', [AccountController::class, 'destroy'])->name('account.destroy');
});
<?php

use Bcampti\Larabase\Http\Controllers\Tenant\OrganizacaoController;
use Bcampti\Larabase\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::prefix('account')->middleware(['auth','hasSuporte'])->group(function(){
    Route::match(['get','post'], '/', [AccountController::class, 'index'])->name('account.index');
    Route::get('cadastrar', [AccountController::class, 'create'])->name('account.create');
    Route::post('salvar', [AccountController::class, 'store'])->name('account.store');
    Route::get('alterar/{id}', [AccountController::class, 'edit'])->name('account.edit');
    Route::put('update/{id}', [AccountController::class, 'update'])->name('account.update');
    Route::delete('excluir/{id}', [AccountController::class, 'destroy'])->name('account.destroy');
});

Route::middleware(['auth','hasSuporte','tenant'])->group(function(){
    Route::prefix('organizacao')->group(function(){
        Route::match(['get','post'], '/', [OrganizacaoController::class, 'index'])->name('organizacao.index');
        Route::get('cadastrar', [OrganizacaoController::class, 'create'])->name('organizacao.create');
        Route::post('salvar', [OrganizacaoController::class, 'store'])->name('organizacao.store');
        Route::get('alterar/{id}', [OrganizacaoController::class, 'edit'])->name('organizacao.edit');
        Route::put('update/{id}', [OrganizacaoController::class, 'update'])->name('organizacao.update');
        Route::delete('excluir/{id}', [OrganizacaoController::class, 'destroy'])->name('organizacao.destroy');
    });
});
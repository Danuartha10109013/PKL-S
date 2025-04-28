<?php

use App\Http\Middleware\CheckAdmin;
use App\Http\Middleware\CheckDirektur;
use App\Http\Middleware\CheckPegawai;
use App\Http\Middleware\CheckSales;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('pengadaan', [
            CheckAdmin::class,
            
        ]);
        $middleware->appendToGroup('produksi', [
            CheckPegawai::class,
            
        ]);
        $middleware->appendToGroup('direktur', [
            CheckDirektur::class,
            
        ]);
        $middleware->appendToGroup('penjualan', [
            CheckSales::class,
            
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

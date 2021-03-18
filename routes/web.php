<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SaleController;
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
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('home');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Usuarios
    Route::get('/usuarios', [UserController::class, 'index'])->name('user.index');
    Route::delete('/usuario/{user}/eliminar', [UserController::class, 'delete'])->name('user.delete')->middleware('ajax');
    Route::get('/usuario/perfil', [UserController::class, 'profile'])->name('user.profile');
    
    // Productos
    Route::get('/productos', [ProductController::class, 'index'])->name('product.index');
    Route::get('/producto/registro', [ProductController::class, 'create'])->name('product.create');
    Route::post('/producto/registro', [ProductController::class, 'store'])->name('product.store')->middleware('ajax');
    Route::delete('producto/{product}/eliminar', [ProductController::class, 'delete'])->name('product.delete')->middleware('ajax');
    Route::get('producto/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::put('producto/{product}/update', [ProductController::class, 'update'])->name('product.update');//->middleware('ajax');
    
    // Proveedores
    Route::get('proveedores', [ProviderController::class, 'index'])->name('provider.index');
    Route::get('proveedor/registro', [ProviderController::class, 'create'])->name('provider.create');
    Route::post('proveedor/registro', [ProviderController::class, 'store'])->name('provider.store');
    Route::delete('proveedor/{provider}/eliminar', [ProviderController::class, 'delete'])->name('provider.delete')->middleware('ajax');
    Route::get('proveedor/{provider}/edit', [ProviderController::class, 'edit'])->name('provider.edit');
    Route::put('proveedor/{provider}/update', [ProviderController::class, 'update'])->name('provider.update');

    // Ventas
    Route::get('/venta-de-productos', [SaleController::class, 'sale'])->name('sales');
    Route::post('/buscar-por-codigo-barras', [SaleController::class, 'findByBarcode'])->name('sales.find.barcode')->middleware('ajax');
    Route::post('/buscar-por-texto', [SaleController::class, 'findByText'])->name('sales.find.text')->middleware('ajax');
});

// require __DIR__.'/auth.php';
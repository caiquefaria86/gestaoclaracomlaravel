<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\catalogsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\FinancialController;
use App\Http\Controllers\Admin\Plans\PlansController;
use App\Http\Controllers\Report\SalesReportController;


Route::get('/dashboard',[HomeController::class, 'index'])->name('dashboard.home.index')->middleware('auth');

Route::get('/dashboard/clientes', [ClientsController::class, 'index'])->name('dashboard.clients.index');
Route::get('/dashboard/cliente/{clientId}', [ClientsController::class, 'show'])->name('dashboard.clients.show');
Route::get('/dashboard/clientes/novo', [ClientsController::class, 'create'])->name('dashboard.clients.create')->middleware('auth');
Route::POST('/dashboard/cliente/new', [ClientsController::class, 'store'])->name('dashboard.clients.store')->middleware('auth');
Route::delete('/dashboard/destroy/{client}', [ClientsController::class, 'destroy'])->name('dashboard.clients.destroy')->middleware('auth');
Route::delete('/dashboard/{client}/editar', [ClientsController::class, 'edit'])->name('dashboard.clients.edit')->middleware('auth');

Route::get('/dashboard/catalogo/', [catalogsController::class, 'index'])->name('dashboard.catalogs.index')->middleware('auth');
Route::POST('/dashboard/catalogo/new', [catalogsController::class, 'store'])->name('dashboard.catalogs.store')->middleware('auth');
Route::delete('/dashboard/catalogo/destroy/{productId}', [catalogsController::class, 'destroy'])->name('dashboard.catalogs.destroy')->middleware('auth');

Route::get('/dashboard/estoque/', [ProductsController::class, 'index'])->name('dashboard.products.index')->middleware('auth');
Route::post('/dashboard/estoque/new', [ProductsController::class, 'store'])->name('dashboard.products.store')->middleware('auth');
Route::delete('/dashboard/estoque/destroy/{productId}', [ProductsController::class, 'destroy'])->name('dashboard.products.destroy')->middleware('auth');

Route::get('/dashboard/venda/nova', [OrdersController::class, 'index'])->name('dashboard.venda.index')->middleware('auth');
Route::get('/dashboard/venda/cliente/{clientId}/1',[OrdersController::class, 'addProducts'])->name('dashboard.venda.addProducts')->middleware('auth');
Route::get('/dashboard/venda/cliente/{clientId}/2',[OrdersController::class, 'create'])->name('dashboard.venda.create')->middleware('auth');
Route::post('/dashboard/venda/cliente/new',[OrdersController::class, 'store'])->name('dashboard.venda.store')->middleware('auth');
Route::get('/dashboard/venda/parcelas/{clientId}/{valor}/{qtd}',[FinancialController::class, 'addParcelas'])->name('dashboard.venda.addParcelas')->middleware('auth');
Route::post('/dashboard/venda/parcelas/new',[FinancialController::class, 'store'])->name('dashboard.financial.store')->middleware('auth');

Route::get('/dashboard/cart/add/{productId}/{qtd}',[CartController::class, 'addCart'])->name('dashboard.addCart')->middleware('auth');
Route::get('/dashboard/cart/remove/{productId}',[CartController::class, 'remove'])->name('dashboard.cart.remove')->middleware('auth');
Route::get('/dashboard/cart',[CartController::class, 'index'])->name('dashboard.cart.index')->middleware('auth');

Route::get('/dashboard/relatorio/vendas/{mes?}/{ano?}/{qtdpg?}', [App\Http\Controllers\Report\SalesReportController::class, 'index'])->name('dashboard.report.sales.index')->middleware('auth');
Route::get('/dashboard/relatorio/financeiro/{mes?}/{ano?}/{qtdpg?}', [App\Http\Controllers\Report\FinancialController::class, 'index'])->name('dashboard.report.financial.index')->middleware('auth');
Route::post('/dashboard/relatorio/financeiro/baixar/{idParcela}', [App\Http\Controllers\Report\FinancialController::class, 'baixar'])->name('dashboard.report.financial.baixar')->middleware('auth');
Route::delete('/dashboard/relatorio/financeiro/destroy/{idParcela}', [App\Http\Controllers\Report\FinancialController::class, 'destroy'])->name('dashboard.report.financial.destroy')->middleware('auth');

Route::get('/painel/planos/novo', [PlansController::class, 'create'])->name('admin.plans.create')->middleware('auth');
Route::post('/painel/planos/new', [PlansController::class, 'createPlan'])->name('admin.plans.new')->middleware('auth');

require __DIR__.'/auth.php';

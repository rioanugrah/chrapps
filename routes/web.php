<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Auth::routes([
    'verify' => true,
    'register' => true
]);

Route::domain(parse_url(env('APP_URL'), PHP_URL_HOST))->group(function () {
    Route::get('/', function () {
        // return redirect(route('login'));
        return view('frontend.index');
    })->name('frontend.index');
});

Route::group(['middleware' => 'auth'], function () {
    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::domain('my.'.parse_url(env('APP_URL'), PHP_URL_HOST))->group(function () {
        Route::get('/', function () {
            return redirect(route('login'));
        });

        Route::group(['middleware' => ['role:Administrator']], function(){
            Route::prefix('admin')->group(function(){
                Route::prefix('mikrotik')->group(function(){
                    Route::controller(App\Http\Controllers\Mikrotik\DashboardController::class)->group(function () {
                        Route::prefix('dashboard')->group(function(){
                            Route::get('/', 'index')->name('dashboard.index');
                            // Route::post('save', 'getInterfaces')->name('getInterfaces');
                        });
                        Route::prefix('realtime')->group(function(){
                            Route::get('cpu', 'cpu')->name('realtime.cpu');
                            Route::get('uptime', 'uptime')->name('realtime.uptime');
                            // Route::post('save', 'getInterfaces')->name('getInterfaces');
                        });
                    });
                    Route::controller(App\Http\Controllers\Mikrotik\InterfaceController::class)->group(function () {
                        Route::prefix('interfaces')->group(function(){
                            Route::get('/', 'getInterfaces')->name('getInterfaces');
                            // Route::post('save', 'getInterfaces')->name('getInterfaces');
                        });
                    });
                    Route::prefix('ip')->group(function(){
                        Route::controller(App\Http\Controllers\Mikrotik\IpAddressController::class)->group(function () {
                            Route::prefix('address')->group(function(){
                                Route::get('/', 'getIpAddresses')->name('getIpAddresses');
                                Route::post('save', 'saveIpAddresses')->name('saveIpAddresses');
                                Route::get('{id}/edit', 'editIpAddresses')->name('editIpAddresses');
                                Route::post('{id}/update', 'updateIpAddresses')->name('updateIpAddresses');
                                Route::delete('{id}/delete', 'deleteIpAddresses')->name('deleteIpAddresses');
                            });
                        });
                        Route::controller(App\Http\Controllers\Mikrotik\PoolController::class)->group(function () {
                            Route::prefix('pool')->group(function(){
                                Route::get('/', 'getPool')->name('getPool');
                                Route::post('save', 'savePool')->name('savePool');
                                // Route::get('{id}/detail', 'detailPool')->name('detailPool');
                                Route::get('{id}/edit', 'editPool')->name('editPool');
                            });
                        });
                    });
                    Route::controller(App\Http\Controllers\Mikrotik\PPPController::class)->group(function () {
                        Route::prefix('ppp')->group(function(){
                            Route::prefix('secret')->group(function(){
                                Route::get('/', 'ppp_secret')->name('getPPPSecret');
                            });
                            Route::prefix('profile')->group(function(){
                                Route::get('/', 'ppp_profile')->name('getPPPProfile');
                            });
                            Route::prefix('active-connection')->group(function(){
                                Route::get('/', 'ppp_active_connection')->name('getPPPActiveConnection');
                            });
                        });
                    });
                    Route::controller(App\Http\Controllers\Mikrotik\FirewallController::class)->group(function () {
                        Route::prefix('firewall')->group(function(){
                            Route::get('/', 'firewall');
                            Route::get('nat', 'firewall_nat');
                            Route::get('mangle', 'firewall_mangle');
                            Route::get('raw', 'firewall_raw');
                        });
                    });
                    Route::controller(App\Http\Controllers\Mikrotik\FirewallController::class)->group(function () {
                        Route::prefix('queues')->group(function(){
                            Route::get('/', 'queues');
                        });
                    });
                    Route::controller(App\Http\Controllers\Mikrotik\DNSController::class)->group(function () {
                        Route::prefix('dns')->group(function(){
                            Route::get('/', 'getDNS')->name('mikrotik.dns');
                            Route::prefix('static')->group(function(){
                                Route::get('/', 'getDNSStatic')->name('mikrotik.dns.static');
                            });
                        });
                    });

                    Route::controller(App\Http\Controllers\TestMikrotikController::class)->group(function () {
                        Route::prefix('test-mikrotik')->group(function(){

                        });
                    });
                });
                Route::controller(App\Http\Controllers\ProductController::class)->group(function () {
                    Route::prefix('products')->group(function(){
                        Route::get('/', 'index')->name('product.index');
                        Route::post('simpan', 'simpan')->name('product.simpan');
                        Route::post('update', 'update')->name('product.update');
                        Route::get('{id}', 'detail')->name('product.detail');
                    });
                });
                Route::controller(App\Http\Controllers\OrdersController::class)->group(function () {
                    Route::prefix('orders')->group(function(){
                        Route::get('/', 'index')->name('order.index');
                        Route::post('simpan', 'simpan')->name('order.simpan');
                        Route::post('perpanjangan/simpan', 'perpanjangan_simpan')->name('order.perpanjangan_simpan');
                        Route::get('{id}', 'detail')->name('order.detail');
                        Route::get('{id}/invoice', 'invoice')->name('order.invoice');
                    });
                });
                Route::controller(App\Http\Controllers\ServiceController::class)->group(function () {
                    Route::prefix('services')->group(function(){
                        Route::get('/', 'index')->name('service.index');
                        Route::get('{id}', 'detail')->name('service.detail');

                        Route::post('{id}/nat/simpan', 'serviceNatRuleSimpan')->name('service.serviceNatRuleSimpan');
                        Route::post('{id}/domain/simpan', 'serviceDomainSimpan')->name('service.serviceDomainSimpan');

                        Route::post('{id}/nat/update', 'serviceNatRuleUpdate')->name('service.serviceNatRuleUpdate');
                        Route::post('{id}/domain/update', 'serviceDomainUpdate')->name('service.serviceDomainUpdate');

                        Route::get('{id}/nat/{idServiceNat}', 'serviceNatRuleDetail')->name('service.serviceNatRuleDetail');
                        Route::get('{id}/domain/{idServiceDomain}', 'serviceDomainDetail')->name('service.serviceDomainDetail');

                        Route::delete('{id}/nat/{idServiceNat}/delete', 'serviceNatRuleDelete')->name('service.serviceNatRuleDelete');
                        Route::delete('{id}/domain/{idServiceDomain}/delete', 'serviceDomainDelete')->name('service.serviceDomainDelete');
                    });
                });
                Route::controller(App\Http\Controllers\ServerController::class)->group(function () {
                    Route::prefix('servers')->group(function(){
                        Route::get('/', 'index')->name('server.index');
                        Route::post('simpan', 'simpan')->name('server.simpan');
                        Route::post('update', 'update')->name('server.update');
                        Route::get('{id}', 'detail')->name('server.detail');
                    });
                });
                Route::controller(App\Http\Controllers\UserController::class)->group(function () {
                    Route::prefix('users')->group(function(){
                        Route::get('/', 'index')->name('admin.users')->middleware('verified');
                        Route::get('create', 'create')->name('admin.users.create')->middleware('verified');
                        Route::post('simpan', 'store')->name('admin.users.store')->middleware('verified');
                        Route::get('{generate}', 'edit')->name('admin.users.edit')->middleware('verified');
                        Route::post('{generate}/update', 'update')->name('admin.users.update')->middleware('verified');
                    });
                });

                Route::controller(App\Http\Controllers\RoleController::class)->group(function () {
                    Route::prefix('roles')->group(function(){
                        Route::get('/', 'index')->name('admin.roles')->middleware('verified');
                        Route::get('create', 'create')->name('admin.roles.create')->middleware('verified');
                        Route::post('simpan', 'store')->name('admin.roles.store')->middleware('verified');
                        Route::get('{id}', 'detail')->name('admin.roles.detail')->middleware('verified');
                        Route::get('{id}/edit', 'edit')->name('admin.roles.edit')->middleware('verified');
                        Route::post('{id}/update', 'update')->name('admin.roles.update')->middleware('verified');
                        Route::delete('{id}/delete', 'destroy')->name('admin.roles.destroy')->middleware('verified');
                    });
                });
                Route::controller(App\Http\Controllers\PermissionController::class)->group(function () {
                    Route::prefix('permissions')->group(function(){
                        Route::get('/', 'index')->name('admin.permission')->middleware('verified');
                        Route::get('create', 'create')->name('admin.permission.create')->middleware('verified');
                        Route::post('simpan', 'store')->name('admin.permission.store')->middleware('verified');
                        Route::get('{id}/edit', 'edit')->name('admin.permission.edit')->middleware('verified');
                        Route::post('{id}/update', 'update')->name('admin.permission.update')->middleware('verified');
                        Route::delete('{id}/delete', 'destroy')->name('admin.permission.destroy')->middleware('verified');
                    });
                });
            });
        });

        Route::group(['middleware' => ['role:Users']], function(){
            Route::controller(App\Http\Controllers\Users\DashboardController::class)->group(function () {
                Route::get('dashboard', 'index')->name('user.home');
            });

            Route::controller(App\Http\Controllers\Users\OrderController::class)->group(function () {
                Route::prefix('orders')->group(function(){
                    Route::get('/', 'index')->name('user.order');
                    Route::get('create', 'create')->name('user.order.create');
                    // Route::get('{id}', 'detail')->name('user.order.detail');
                    Route::post('perpanjangan/simpan', 'perpanjangan_simpan')->name('user.order.perpanjangan_simpan');
                    Route::get('{id}', 'detail')->name('user.order.detail');
                    Route::get('{id}/checkout', 'checkout')->name('user.order.checkout');
                    Route::post('{id}/buy_now', 'buy_now')->name('user.order.buy_now');
                    Route::get('{id}/invoice', 'invoice')->name('user.order.invoice');
                });
            });

            Route::controller(App\Http\Controllers\Users\ServiceController::class)->group(function () {
                Route::prefix('services')->group(function(){
                    Route::get('/', 'index')->name('user.service.index');
                    Route::get('{id}', 'detail')->name('user.service.detail');

                    Route::post('{id}/nat/simpan', 'serviceNatRuleSimpan')->name('user.service.serviceNatRuleSimpan');
                    Route::post('{id}/domain/simpan', 'serviceDomainSimpan')->name('user.service.serviceDomainSimpan');

                    Route::post('{id}/nat/update', 'serviceNatRuleUpdate')->name('user.service.serviceNatRuleUpdate');
                    Route::post('{id}/domain/update', 'serviceDomainUpdate')->name('user.service.serviceDomainUpdate');

                    Route::get('{id}/nat/{idServiceNat}', 'serviceNatRuleDetail')->name('user.service.serviceNatRuleDetail');
                    Route::get('{id}/domain/{idServiceDomain}', 'serviceDomainDetail')->name('service.serviceDomainDetail');

                    Route::delete('{id}/nat/{idServiceNat}/delete', 'serviceNatRuleDelete')->name('user.service.serviceNatRuleDelete');
                    Route::delete('{id}/domain/{idServiceDomain}/delete', 'serviceDomainDelete')->name('user.service.serviceDomainDelete');
                });
            });
        });
    });
});

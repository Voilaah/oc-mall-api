<?php

Route::group([
        'middleware' => ['web'],
        'prefix' => 'api',
        'namespace' => 'Voilaah\MallApi\Http\Api'
    ], function () {

    Route::resource('docs', 'Documentation');
    Route::resource('ping', 'Ping');

    // Route::group(['prefix' => 'me', 'middleware' => '\Tymon\JWTAuth\Middleware\GetUserFromToken']  , function() {
    Route::group([
        'middleware' => ['jwt.auth'],
        'prefix' => 'auth/me'
    ], function() {

        Route::get(
            'profile',
            'CustomerController'
        )->name('api.auth.customer');

        Route::resource('addresses', 'Addresses');
        Route::resource('orders', 'Orders');

    });

    // Simple Resources related
    Route::resource('products', 'Products');
    Route::get('categories/{recordId}', 'Categories@show')
        ->where('recordId', '.*')
        ->name('categories.show');
    Route::resource('categories', 'Categories');
    // Route::resource('categories', 'Categories')->only([
    //     "index",
    //     "store",
    //     "update",
    //     "destroy",
    // ]);
    Route::resource('brands', 'Brands');
    Route::resource('productscategory', 'ProductsCategory');

    // Cart related
    // Route::get('cart/reset', 'ShoppingCartController@killme');
    Route::resource('cart', 'ShoppingCartController')->only([
        "index",
        "store",
        "update",
        "show",
        "destroy",
    ]);

});

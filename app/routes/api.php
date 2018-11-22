<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request)
{
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () 
{
    Route::group(['prefix' => 'products'], function () 
    {
        Route::get('/',
                        [ 'as' => 'product-list', 
                        'uses' => '\Stock\Products\Controllers\ProductController@listAll' 
                    ]);

        Route::get('/{id}',
                            [ 'as' => 'view-product', 
                            'uses' => '\Stock\Products\Controllers\ProductController@findById' 
                            ]);

        Route::put('/{id}',
                            [ 'as' => 'update-product', 
                            'uses' => '\Stock\Products\Controllers\ProductController@update' 
                            ]);

        Route::delete('/{id}',
                            [ 'as' => 'delete-product', 
                            'uses' => '\Stock\Products\Controllers\ProductController@remove' 
                            ]);

    });
    
    Route::group(['prefix' => 'upload'], function () 
    {
        Route::post('/',[ 'as' => 'product-upload', 
                         'uses' => '\Stock\Plan\Controllers\ImportController@importProduct' 
                    ]);     

        Route::group(['prefix' => 'check-proccess'], function () 
        {
            Route::get('/{id}',[ 'as' => 'check-procces-by-id', 
                         'uses' => '\Stock\Jobs\Controllers\JobsPlanProductsController@findById' 
                    ]);

            Route::get('/',[ 'as' => 'check-all-procces', 
                         'uses' => '\Stock\Jobs\Controllers\JobsPlanProductsController@listAll' 
                    ]);     
        });
    });

});

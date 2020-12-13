<?php
/**
 * @Routing methods :-
 * Route::get($route, $controller>$method);
 * Route::post($route, $controller>$method);
 * Route::middleware(array $middlewares, function() {
 *  Write Routes here which will go through the middleware
 * });
 * 
 * @These Routes are for testing purposes.
 */

Route::middleware(['TestMiddleware'], function(){
    Route::get('/test', 'TestController>index');
    Route::get('/test/:id/:some', 'TestController>show');
    Route::get('/test/:id', 'TestController>show');
    Route::get('/show', 'TestController>update');        
});

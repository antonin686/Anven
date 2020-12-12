<?php

Route::middleware(['TestMiddleware'], function(){
    Route::get('/test', 'TestController>index');
    Route::post('/test', 'TestController>update');    
});

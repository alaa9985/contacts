<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('pack', 'PackCrudController');
    Route::crud('ticket', 'TicketCrudController');
    Route::get('ticket/{id}/assign', 'TicketCrudController@assign');
    Route::crud('contact', 'ContactCrudController');
    Route::crud('attribute', 'AttributeCrudController');
}); // this should be the absolute last line of this file
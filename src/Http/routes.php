<?php

Route::group([
    'namespace'  => 'Deirdrelear\Seat\Infrastructure\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale', 'can:infrastructure.corporation'],
    'prefix' => 'infrastructure/corporation'
], function () {
    Route::get('dockstructures', [
        'as'   => 'infrastructure.corporation_dockstructures',
        'uses' => 'InfrastructureCorporationController@dockstructures',
    ]);

    Route::get('navstructures', [
        'as'   => 'infrastructure.corporation_navstructures',
        'uses' => 'InfrastructureCorporationController@navstructures',
    ]);

    Route::get('ihubs', [
        'as'   => 'infrastructure.corporation_ihubs',
        'uses' => 'InfrastructureCorporationController@ihubs',
    ]);

    Route::get('miningstructures', [
        'as'   => 'infrastructure.corporation_miningstructures',
        'uses' => 'InfrastructureCorporationController@miningstructures',
    ]);
});

Route::group([
    'namespace'  => 'Deirdrelear\Seat\Infrastructure\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale', 'can:infrastructure.alliance'],
    'prefix' => 'infrastructure/alliance'
], function () {
    Route::get('dockstructures', [
        'as'   => 'infrastructure.alliance_dockstructures',
        'uses' => 'InfrastructureAllianceController@dockstructures',
    ]);

    Route::get('navstructures', [
        'as'   => 'infrastructure.alliance_navstructures',
        'uses' => 'InfrastructureAllianceController@navstructures',
    ]);

    Route::get('ihubs', [
        'as'   => 'infrastructure.alliance_ihubs',
        'uses' => 'InfrastructureAllianceController@ihubs',
    ]);

    Route::get('miningstructures', [
        'as'   => 'infrastructure.alliance_miningstructures',
        'uses' => 'InfrastructureAllianceController@miningstructures',
    ]);
});

Route::group([
    'namespace'  => 'Deirdrelear\Seat\Infrastructure\Http\Controllers',
    'middleware' => ['web', 'auth', 'locale', 'can:infrastructure.global'],
    'prefix' => 'infrastructure/global'
], function () {
    Route::get('dockstructures', [
        'as'   => 'infrastructure.global_dockstructures',
        'uses' => 'InfrastructureGlobalController@dockstructures',
    ]);

    Route::get('navstructures', [
        'as'   => 'infrastructure.global_navstructures',
        'uses' => 'InfrastructureGlobalController@navstructures',
    ]);

    Route::get('ihubs', [
        'as'   => 'infrastructure.global_ihubs',
        'uses' => 'InfrastructureGlobalController@ihubs',
    ]);

    Route::get('miningstructures', [
        'as'   => 'infrastructure.global_miningstructures',
        'uses' => 'InfrastructureGlobalController@miningstructures',
    ]);
});

@extends('web::layouts.grids.12')

@section('title', 'title')
@section('page_header', 'Infrastructure: IHUB\'s')

@push('head')
@endpush

@section('full')
    @foreach($ihubs as $ihub)
        <h3>System: {{ $ihub->solarSystem->name }}</h3>
        Corporation: {{ $ihub->corporation->name }}<br>
        Upgrades:<br>
        @foreach($ihub->upgrades as $upgrade)
            {{ $upgrade->upgrade_type->typeName }}
            <br>
        @endforeach
        <hr>
    @endforeach
@stop
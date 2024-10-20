@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Infrastructure: IHUB\'s')
@section('infrastructure_page_header', 'Infrastructure: IHUB\'s')

@section('infrastructure_content')
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
@endsection

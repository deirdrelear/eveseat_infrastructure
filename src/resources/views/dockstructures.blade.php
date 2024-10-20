@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Infrastructure: Stations')
@section('infrastructure_page_header', 'Infrastructure: Stations')

@section('infrastructure_content')
    @foreach($dockingStructures as $dockingStructure)
        <h3>{{ $dockingStructure->structure_type->typeName }} {{ $dockingStructure->name }}</h3>
        Solar System: {{ $dockingStructure->solarSystem->name }}<br>
        Corporation: {{ $dockingStructure->corporation->name }}<br>
        Fuel:<br>
        @foreach($dockingStructure->fuels as $fuel)
            {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
        @endforeach
        <hr>
    @endforeach
@endsection
@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Infrastructure: Navigation Structures')
@section('infrastructure_page_header', 'Infrastructure: Navigation Structures')

@section('infrastructure_content')
    @foreach($navigationStructures as $navigationStructure)
        <h3>{{ $navigationStructure->structure_type->typeName }} {{ $navigationStructure->name }}</h3>
        Solar System: {{ $navigationStructure->solarSystem->name }}<br>
        Corporation: {{ $navigationStructure->corporation->name }}<br>
        Fuel:<br>
        @foreach($navigationStructure->fuels as $fuel)
            {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
        @endforeach
        <hr>
    @endforeach
@endsection

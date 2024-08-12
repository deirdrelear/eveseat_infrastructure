@extends('web::layouts.grids.12')

@section('title', 'Global Infrastructure: Stations')
@section('page_header', 'Global Infrastructure: Stations')

@push('head')
@endpush

@section('full')
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th scope="col">Structure Type</th>
            <th scope="col">Name</th>
            <th scope="col">Solar System</th>
            <th scope="col">Corporation</th>
            <th scope="col">Fuel</th>
        </tr>
        </thead>
        <tbody>
        @foreach($dockingStructures as $dockingStructure)
            <tr>
                <td>{{ $dockingStructure->structure_type->typeName }}</td>
                <td>{{ $dockingStructure->name }}</td>
                <td>{{ $dockingStructure->solarSystem->name }}</td>
                <td>{{ $dockingStructure->corporation->name }}</td>
                <td>
                    @foreach($dockingStructure->fuels as $fuel)
                        {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="container">
@stop

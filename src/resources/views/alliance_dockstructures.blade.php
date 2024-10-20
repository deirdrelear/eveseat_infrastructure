@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Alliance Infrastructure: Stations')
@section('infrastructure_page_header', 'Alliance Infrastructure: Stations')

@section('infrastructure_content')
    <table class="table table-striped table-hover" id="allianceDockingStructuresTable">
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
@endsection


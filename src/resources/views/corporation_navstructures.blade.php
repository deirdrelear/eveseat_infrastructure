@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Corporation Infrastructure: Navigation Structures')
@section('infrastructure_page_header', 'Corporation Infrastructure: Navigation Structures')

@section('infrastructure_content')
    <table class="table table-striped table-hover" id="corporationNavigationStructuresTable">
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
        @foreach($navigationStructures as $navigationStructure)
            <tr>
                <td>{{ $navigationStructure->structure_type->typeName }}</td>
                <td>{{ $navigationStructure->name }}</td>
                <td>{{ $navigationStructure->solarSystem->name }}</td>
                <td>{{ $navigationStructure->corporation->name }}</td>
                <td>
                    @foreach($navigationStructure->fuels as $fuel)
                        {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
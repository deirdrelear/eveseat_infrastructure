@extends('web::layouts.grids.12')

@section('title', 'Alliance Infrastructure: Navigation Structures')
@section('page_header', 'Alliance Infrastructure: Navigation Structures')

@push('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush

@section('full')
    <table class="table table-striped table-hover" id="allianceNavigationStructuresTable">
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
@stop

@push('javascript')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#allianceNavigationStructuresTable').DataTable();
        });
    </script>
@endpush

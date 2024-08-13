@extends('web::layouts.grids.12')

@section('title', 'Global Infrastructure: Stations')
@section('page_header', 'Global Infrastructure: Stations')

@push('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush

@section('full')
    <table class="table table-striped table-hover" id="globalDockingStructuresTable">
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

@push('javascript')
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#globalDockingStructuresTable').DataTable();
        });
    </script>
@endpush

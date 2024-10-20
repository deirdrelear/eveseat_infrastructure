@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Corporation Infrastructure: Metenoxes')
@section('infrastructure_page_header', 'Corporation Infrastructure: Metenoxes')

@section('infrastructure_content')
    <table class="table table-striped table-hover" id="corporationMiningStructuresTable">
        <thead>
        <tr>
            <th scope="col">Structure Type</th>
            <th scope="col">Name</th>
            <th scope="col">Solar System</th>
            <th scope="col">Moon</th>
            <th scope="col">Corporation</th>
            <th scope="col">Fuel</th>
            <th scope="col">Profit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($miningStructures as $miningStructure)
            <tr>
                <td>{{ $miningStructure->structure_type->typeName }}</td>
                <td>{{ $miningStructure->name }}</td>
                <td>{{ $miningStructure->solarSystem->name }}</td>
                <td></td>
                <td>{{ $miningStructure->corporation->name }}</td>
                <td>
                    @foreach($miningStructure->fuels as $fuel)
                        {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
                    @endforeach
                </td>
                <td></td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
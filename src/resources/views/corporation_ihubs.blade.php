@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Corporation Infrastructure: IHUB\'s')
@section('infrastructure_page_header', 'Corporation Infrastructure: IHUB\'s')

@section('infrastructure_content')
    <table class="table table-striped table-hover" id="corporationIhubsTable">
        <thead>
        <tr>
            <th scope="col">Solar System</th>
            <th scope="col">Corporation</th>
            <th scope="col">Upgrades</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ihubs as $ihub)
            <tr>
                <td>{{ $ihub->solarSystem->name }}</td>
                <td>{{ $ihub->corporation->name }}</td>
                <td>
                    @foreach($ihub->upgrades as $upgrade)
                        {{ $upgrade->upgrade_type->typeName }}<br>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
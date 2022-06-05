@extends('web::layouts.grids.12')

@section('title', 'Global Infrastructure: IHUB\'s')
@section('page_header', 'Global Infrastructure: IHUB\'s')

@push('head')
@endpush

@section('full')
    <table class="table table-hover">
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
@stop
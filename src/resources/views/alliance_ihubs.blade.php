@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Alliance Infrastructure: IHUB\'s')
@section('infrastructure_page_header', 'Alliance Infrastructure: IHUB\'s')

@section('infrastructure_content')
    <table class="table table-striped table-hover data-table" id="allianceIhubsTable">
        <thead>
        <tr>
            <th scope="col">Region</th>
            <th scope="col">Solar System</th>
            <th scope="col">Corporation</th>
            <th scope="col">Upgrades</th>
            <th scope="col" class="text-center">Fitting</th>
        </tr>
        </thead>
        <tbody>
        @foreach($ihubs as $ihub)
            @php($fittingModalId = 'structure-fitting-' . ($ihub->item_id ?? $loop->iteration))
            <tr>
                <td>{{ optional(optional($ihub->solarSystem)->region)->name }}</td>
                <td>{{ $ihub->solarSystem->name }}</td>
                <td>{{ $ihub->corporation->name }}</td>
                <td>
                    @foreach($ihub->upgrades as $upgrade)
                        {{ $upgrade->upgrade_type->typeName }}<br>
                    @endforeach
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#{{ $fittingModalId }}">
                        View Fitting
                    </button>
                </td>
            </tr>
            @push('structure-fitting-modals')
                @include('infrastructure::partials.structure_fitting_modal', [
                    'structure' => $ihub,
                    'modal_id' => $fittingModalId,
                ])
            @endpush
        @endforeach
        </tbody>
    </table>
    @stack('structure-fitting-modals')
@endsection

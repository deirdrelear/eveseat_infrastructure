@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Alliance Infrastructure: Navigation Structures')
@section('infrastructure_page_header', 'Alliance Infrastructure: Navigation Structures')

@section('infrastructure_content')
    <table class="table table-striped table-hover data-table" id="allianceNavigationStructuresTable">
        <thead>
        <tr>
            <th scope="col">Structure Type</th>
            <th scope="col">Name</th>
            <th scope="col">Solar System</th>
            <th scope="col">Region</th>
            <th scope="col">Corporation</th>
            <th scope="col">Fuel</th>
            <th scope="col" class="text-center">Fitting</th>
        </tr>
        </thead>
        <tbody>
        @foreach($navigationStructures as $navigationStructure)
            @php($fittingModalId = 'structure-fitting-' . ($navigationStructure->item_id ?? $loop->iteration))
            <tr>
                <td>{{ $navigationStructure->structure_type->typeName }}</td>
                <td>{{ $navigationStructure->name }}</td>
                <td>{{ $navigationStructure->solarSystem->name }}</td>
                <td>{{ optional(optional($navigationStructure->solarSystem)->region)->name }}</td>
                <td>{{ $navigationStructure->corporation->name }}</td>
                <td data-order="{{ $navigationStructure->fuel_block_quantity ?? 0 }}">
                    @foreach($navigationStructure->fuels as $fuel)
                        {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
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
                    'structure' => $navigationStructure,
                    'modal_id' => $fittingModalId,
                ])
            @endpush
        @endforeach
        </tbody>
    </table>
    @stack('structure-fitting-modals')
@endsection

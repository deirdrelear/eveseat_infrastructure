@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Global Infrastructure: Stations')
@section('infrastructure_page_header', 'Global Infrastructure: Stations')

@section('infrastructure_content')
    <table class="table table-striped table-hover data-table" id="globalDockingStructuresTable">
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
        @foreach($dockingStructures as $dockingStructure)
            @php($fittingModalId = 'structure-fitting-' . ($dockingStructure->item_id ?? $loop->iteration))
            <tr>
                <td>{{ $dockingStructure->structure_type->typeName }}</td>
                <td>{{ $dockingStructure->name }}</td>
                <td>{{ $dockingStructure->solarSystem->name }}</td>
                <td>{{ optional(optional($dockingStructure->solarSystem)->region)->name }}</td>
                <td>{{ $dockingStructure->corporation->name }}</td>
                <td data-order="{{ $dockingStructure->fuel_block_quantity ?? 0 }}">
                    @foreach($dockingStructure->fuels as $fuel)
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
                    'structure' => $dockingStructure,
                    'modal_id' => $fittingModalId,
                ])
            @endpush
        @endforeach
        </tbody>
    </table>
    @stack('structure-fitting-modals')
    <div class="container">
@endsection

@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Corporation Infrastructure: Metenoxes')
@section('infrastructure_page_header', 'Corporation Infrastructure: Metenoxes')

@section('infrastructure_content')
    <table class="table table-striped table-hover data-table" id="corporationMiningStructuresTable">
        <thead>
        <tr>
            <th scope="col">Structure Type</th>
            <th scope="col">Name</th>
            <th scope="col">State</th>
            <th scope="col">Moon</th>
            <th scope="col">Region</th>
            <th scope="col">Corporation</th>
            <th scope="col">Fuel</th>
            <th scope="col" class="text-center">Fitting</th>
            <th scope="col">Profit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($miningStructures as $miningStructure)
            @php($fittingModalId = 'structure-fitting-' . ($miningStructure->item_id ?? $loop->iteration))
            <tr>
                <td>{{ $miningStructure->structure_type->typeName }}</td>
                <td>{{ $miningStructure->name }}</td>
                <td>{{ $miningStructure->state }}</td>
                <td>{{ $miningStructure->nearest_moon }}</td>
                <td>{{ optional(optional($miningStructure->solarSystem)->region)->name }}</td>
                <td>{{ $miningStructure->corporation->name }}</td>
                <td data-order="{{ $miningStructure->fuel_block_quantity ?? 0 }}">
                    @foreach($miningStructure->fuels as $fuel)
                        {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
                    @endforeach
                </td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#{{ $fittingModalId }}">
                        View Fitting
                    </button>
                </td>
                <td>
                    @if($miningStructure->profit > 0)
                        {{ number_format($miningStructure->profit, 2) }} ISK
                    @else
                        Нет данных
                    @endif
                </td>
            </tr>
            @push('structure-fitting-modals')
                @include('infrastructure::partials.structure_fitting_modal', [
                    'structure' => $miningStructure,
                    'modal_id' => $fittingModalId,
                ])
            @endpush
        @endforeach
        </tbody>
    </table>
    @stack('structure-fitting-modals')
@endsection
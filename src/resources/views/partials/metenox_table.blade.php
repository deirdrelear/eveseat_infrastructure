@php
    $tableId = $tableId ?? 'metenoxStructuresTable';
@endphp

<form method="GET" action="{{ route($routeName) }}" class="form-inline mb-3">
    <div class="form-group">
        <label for="{{ $tableId }}-target-date" class="mr-2">Fuel target date:</label>
        <input
            type="date"
            id="{{ $tableId }}-target-date"
            name="target_date"
            class="form-control"
            min="{{ now()->format('Y-m-d') }}"
            value="{{ $targetDate->format('Y-m-d') }}"
            onchange="this.form.submit()"
        >
    </div>
</form>

<table class="table table-striped table-hover data-table" id="{{ $tableId }}">
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
        <th scope="col">Monthly Economics</th>
        <th scope="col">Shutdown Date</th>
        <th scope="col">Required Fuel</th>
    </tr>
    </thead>
    <tbody>
    @foreach($miningStructures as $miningStructure)
        @php($fittingModalId = 'structure-fitting-' . ($miningStructure->item_id ?? $loop->iteration))
        <tr>
            <td>{{ optional($miningStructure->structure_type)->typeName ?? ('Type ' . $miningStructure->type_id) }}</td>
            <td>{{ $miningStructure->name ?? '—' }}</td>
            <td>{{ $miningStructure->state ?? '—' }}</td>
            <td>{{ $miningStructure->nearest_moon ?? 'Неизвестно' }}</td>
            <td>{{ optional(optional($miningStructure->solarSystem)->region)->name ?? '—' }}</td>
            <td>{{ optional($miningStructure->corporation)->name ?? '—' }}</td>
            <td data-order="{{ $miningStructure->fuel_block_quantity ?? 0 }}">
                @forelse($miningStructure->fuels as $fuel)
                    {{ optional($fuel->fuel_type)->typeName ?? ('Type ' . $fuel->type_id) }} - {{ number_format($fuel->quantity) }}<br>
                @empty
                    —
                @endforelse
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-sm btn-outline-info" data-toggle="modal" data-target="#{{ $fittingModalId }}">
                    View Fitting
                </button>
            </td>
            <td data-order="{{ $miningStructure->net_profit ?? 0 }}">
                @if($miningStructure->profit_status === 'available')
                    Gross: {{ number_format($miningStructure->gross_profit, 0) }} ISK<br>
                    Fuel: {{ number_format($miningStructure->fuel_cost, 0) }} ISK<br>
                    <strong>Net: {{ number_format($miningStructure->net_profit, 0) }} ISK</strong>
                @elseif($miningStructure->profit_status === 'unavailable')
                    Данные о составе луны или ценах недоступны
                @else
                    Невозможно определить луну
                @endif
            </td>
            <td>
                FB: {{ $miningStructure->shutdown_date['fuelBlock']->format('Y-m-d H:i') }}<br>
                MG: {{ $miningStructure->shutdown_date['magmaticGas']->format('Y-m-d H:i') }}
            </td>
            <td>
                @if($miningStructure->required_fuel['fuelBlocks'] > 0 || $miningStructure->required_fuel['magmaticGas'] > 0)
                    FB: {{ number_format($miningStructure->required_fuel['fuelBlocks']) }}<br>
                    MG: {{ number_format($miningStructure->required_fuel['magmaticGas']) }}
                @else
                    Все хорошо
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

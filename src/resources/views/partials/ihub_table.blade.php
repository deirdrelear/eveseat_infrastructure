<table class="table table-striped table-hover data-table" id="{{ $tableId }}">
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
        @php
            $fittingModalId = 'structure-fitting-' . ($ihub->item_id ?? $loop->iteration);
            $solarSystem = $ihub->solarSystem ?? null;
            $region = $solarSystem->region ?? null;
            $corporation = $ihub->corporation ?? null;
        @endphp
        <tr>
            <td>{{ $region->name ?? '—' }}</td>
            <td>{{ $solarSystem->name ?? ('System ID ' . ($ihub->location_id ?? 'unknown')) }}</td>
            <td>{{ $corporation->name ?? ('Corporation ID ' . ($ihub->corporation_id ?? 'unknown')) }}</td>
            <td>
                @forelse($ihub->upgrades ?? [] as $upgrade)
                    @php
                        $upgradeType = $upgrade->upgrade_type ?? null;
                        $state = $upgrade->location_flag ?? null;
                        if ($state && \Illuminate\Support\Str::startsWith($state, 'Structure')) {
                            $state = \Illuminate\Support\Str::after($state, 'Structure');
                        }
                    @endphp
                    {{ $upgradeType->typeName ?? ('Type ' . ($upgrade->type_id ?? 'unknown')) }}
                    @if($state)
                        <small class="text-muted">({{ $state }})</small>
                    @endif
                    <br>
                @empty
                    <span class="text-muted">No upgrades found</span>
                @endforelse
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

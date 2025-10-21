@php
    $structureName = $structure->name ?? optional($structure->structure_type)->typeName ?? optional($structure->type)->typeName ?? 'Structure';
    $structureType = optional($structure->structure_type)->typeName ?? optional($structure->type)->typeName ?? 'Unknown';
    $solarSystem = optional($structure->solarSystem);
    $region = optional($solarSystem->region);
    $corporation = optional($structure->corporation);
    $fittingItems = $structure->fitting_items ?? [];
@endphp

<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modal_id }}-label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="{{ $modal_id }}-label">{{ $structureName }} — Fitting overview</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <dl class="row mb-3">
                    <dt class="col-sm-4">Structure type</dt>
                    <dd class="col-sm-8">{{ $structureType }}</dd>
                    @if($solarSystem->name)
                        <dt class="col-sm-4">Solar system</dt>
                        <dd class="col-sm-8">{{ $solarSystem->name }}</dd>
                    @endif
                    @if($region->name)
                        <dt class="col-sm-4">Region</dt>
                        <dd class="col-sm-8">{{ $region->name }}</dd>
                    @endif
                    @if($corporation->name)
                        <dt class="col-sm-4">Corporation</dt>
                        <dd class="col-sm-8">{{ $corporation->name }}</dd>
                    @endif
                </dl>

                @if(count($fittingItems) === 0)
                    <p class="mb-0 text-muted">No fitting information is available for this structure.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm table-striped mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">Module</th>
                                    <th scope="col" class="text-right">Quantity</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($fittingItems as $item)
                                    @php
                                        $moduleName = optional($item->type)->typeName ?? 'Unknown';
                                        $quantity = $item->quantity ?? 0;
                                        $state = $item->state ?? null;
                                        if ($state && \Illuminate\Support\Str::startsWith($state, 'Structure')) {
                                            $state = \Illuminate\Support\Str::after($state, 'Structure');
                                        }
                                        $stateLabel = $state ? \Illuminate\Support\Str::title(str_replace('_', ' ', $state)) : '—';
                                    @endphp
                                    <tr>
                                        <td>{{ $moduleName }}</td>
                                        <td class="text-right">{{ $quantity }}</td>
                                        <td>{{ $stateLabel }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

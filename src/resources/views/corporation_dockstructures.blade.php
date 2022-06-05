@extends('web::layouts.grids.12')

@section('title', 'Corporation Infrastructure: Stations')
@section('page_header', 'Corporation Infrastructure: Stations')

@push('head')
@endpush

@section('full')
    @if(count($dockingStructures) > 0)
        <!-- Сначала выводим табы с именами корпораций -->
        @foreach($corporationNames as $corporationId => $corporationName)
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="{{ $corporationId }}">{{ $corporationName }}</a>
                </li>
            </ul>
        @endforeach

        <!-- Теперь выводим содержимое табов -->
        @foreach($corporationNames as $corporationId => $corporationName)
            <div class="tab-content">
                <div class="tab-pane fade show active" id={{ $corporationId }}>
                    <!-- Выводим таблицу -->
                    <table class="table table-striped table-hover">
                        <!-- Сначала выводим заголовок таблицы -->
                        <thead>
                            <tr>
                                <th scope="col">Structure Type</th>
                                <th scope="col">Name</th>
                                <th scope="col">Solar System</th>
                                <th scope="col">Fuel</th>
                            </tr>
                        </thead>

                        <!-- Теперь значения -->
                        <tbody>
                            @foreach($dockingStructures as $dockingStructure)
                                @if($dockingStructure->corporation->corporation_id == $corporationId)
                                    <tr>
                                        <td>{{ $dockingStructure->structure_type->typeName }}</td>
                                        <td>{{ $dockingStructure->name }}</td>
                                        <td>{{ $dockingStructure->solarSystem->name }}</td>
                                        <td>
                                            @foreach($dockingStructure->fuels as $fuel)
                                                {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
                                            @endforeach
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
@stop
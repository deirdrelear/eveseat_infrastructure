@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Alliance Infrastructure: Metenoxes')
@section('infrastructure_page_header', 'Alliance Infrastructure: Metenoxes')

@section('infrastructure_content')
    <div class="form-group date-filter-container">
        <label for="date-filter">Выберите дату для расчета заправки:</label>
        <input type="text" id="date-filter" class="form-control flatpickr date-filter-input" placeholder="Выберите дату" value="{{ $targetDate->format('Y-m-d') }}">
    </div>

    <table class="table table-striped table-hover" id="allianceminingStructuresTable">
        <thead>
        <tr>
            <th scope="col">Structure Type</th>
            <th scope="col">Name</th>
            <th scope="col">State</th>
            <th scope="col">Moon</th>
            <th scope="col">Corporation</th>
            <th scope="col">Fuel</th>
            <th scope="col">Profit</th>
            <th scope="col">Shutdown Date</th>
            <th scope="col">Required Fuel</th>
        </tr>
        </thead>
        <tbody>
        @foreach($miningStructures as $miningStructure)
            <tr>
                <td>{{ $miningStructure->structure_type->typeName }}</td>
                <td>{{ $miningStructure->name }}</td>
                <td>{{ $miningStructure->state }}</td>
                <td>{{ $miningStructure->nearest_moon }}</td>
                <td>{{ $miningStructure->corporation->name }}</td>
                <td>
                    @foreach($miningStructure->fuels as $fuel)
                        {{ $fuel->fuel_type->typeName }} - {{ $fuel->quantity }}<br>
                    @endforeach
                </td>
                <td>
                    @if($miningStructure->profit_status === 'available')
                        Прибыль: {{ number_format($miningStructure->net_profit, 2) }} ISK
                    @elseif($miningStructure->profit_status === 'unavailable')
                        Данные о прибыли недоступны
                    @else
                        Невозможно рассчитать прибыль
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
        @endforeach
        </tbody>
    </table>
    <div class="container">

    @push('javascript')
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">
        <style>
            .date-filter-container {
                width: 25%;
                min-width: 200px;
                max-width: 300px;
            }
            .date-filter-input {
                width: 100%;
            }
        </style>
        <script>
            flatpickr("#date-filter", {
                enableTime: false,
                dateFormat: "Y-m-d",
                theme: "dark",
                defaultDate: "{{ $targetDate->format('Y-m-d') }}",
                onChange: function(selectedDates, dateStr, instance) {
                    window.location.href = '{{ route("infrastructure.alliance_miningstructures") }}?target_date=' + dateStr;
                }
            });
        </script>
    @endpush 

@endsection
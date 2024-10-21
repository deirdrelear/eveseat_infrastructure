@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Alliance Infrastructure: Metenoxes')
@section('infrastructure_page_header', 'Alliance Infrastructure: Metenoxes')

@section('infrastructure_content')
    <div class="form-group date-filter-container">
        <label for="date-filter">Выберите дату для расчета заправки:</label>
        <input type="text" id="date-filter" class="form-control flatpickr date-filter-input" placeholder="Выберите дату">
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
                    @if($miningStructure->profit > 0)
                        {{ number_format($miningStructure->profit, 2) }} ISK
                    @else
                        Нет данных
                    @endif
                </td>
                <td>
                    @php
                        $fuelBlocks = $miningStructure->fuels->whereIn('fuel_type.typeID', [4051, 4246, 4247, 4312, 36945])->sum('quantity');
                        $magmaticGas = $miningStructure->fuels->where('fuel_type.typeID', 16275)->first()->quantity ?? 0;
                        $fuelBlockHours = $fuelBlocks / 5;
                        $magmaticGasHours = $magmaticGas / 88;
                        $shutdownHours = min($fuelBlockHours, $magmaticGasHours);
                        $shutdownDate = now()->addHours($shutdownHours);
                    @endphp
                    {{ $shutdownDate->format('Y-m-d H:i') }}
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
                defaultDate: new Date(new Date().getFullYear(), new Date().getMonth() + 1, 1)
            });
        
            document.getElementById('date-filter').addEventListener('change', function() {
                // Здесь добавьте логику для обновления данных на основе выбранной даты
                console.log('Выбрана дата:', this.value);
                // Например, можно перезагрузить таблицу с новыми данными
                // $('#globalminingStructuresTable').DataTable().ajax.reload();
            });
        </script>
    @endpush 

@endsection
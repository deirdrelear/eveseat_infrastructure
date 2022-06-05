@extends('layouts.mining');
@section('content')
    @foreach($moonsToMine as $moonToMine)
        <h3>Structure: {{ $moonToMine['text']['structureName'] }}</h3>
        Прошло времении с подрыва: {{ $moonToMine['interval']->d }} дней {{ $moonToMine['interval']->h }} часов <br>
        <h4>Исходные объемы руды:</h4>
            @foreach($moonToMine['text']['oreVolumeByType'] as $oreName => $oreVolume)
                Название руды: {{ $oreName }}, Объем: {{ round($oreVolume) }} <br>
            @endforeach
        <br>

        <h4>Выкопано руды:</h4>
        @foreach($moonToMine['all_name_group_mining'] as $oreMining)
            Название руды: {{ $oreMining['type_name'] }}, Объем: {{ round($oreMining['quantity']*10) }} <br>
        @endforeach

        <hr>
    @endforeach
@endsection

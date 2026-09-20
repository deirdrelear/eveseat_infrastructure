@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Alliance Infrastructure: Metenoxes')
@section('infrastructure_page_header', 'Alliance Infrastructure: Metenoxes')

@section('infrastructure_content')
    @include('infrastructure::partials.metenox_table', [
        'miningStructures' => $miningStructures,
        'targetDate' => $targetDate,
        'routeName' => 'infrastructure.alliance_miningstructures',
        'tableId' => 'allianceMiningStructuresTable',
    ])
@endsection

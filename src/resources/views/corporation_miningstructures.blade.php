@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Corporation Infrastructure: Metenoxes')
@section('infrastructure_page_header', 'Corporation Infrastructure: Metenoxes')

@section('infrastructure_content')
    @include('infrastructure::partials.metenox_table', [
        'miningStructures' => $miningStructures,
        'targetDate' => $targetDate,
        'routeName' => 'infrastructure.corporation_miningstructures',
        'tableId' => 'corporationMiningStructuresTable',
    ])
@endsection

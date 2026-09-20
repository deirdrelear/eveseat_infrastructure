@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Global Infrastructure: Metenoxes')
@section('infrastructure_page_header', 'Global Infrastructure: Metenoxes')

@section('infrastructure_content')
    @include('infrastructure::partials.metenox_table', [
        'miningStructures' => $miningStructures,
        'targetDate' => $targetDate,
        'routeName' => 'infrastructure.global_miningstructures',
        'tableId' => 'globalMiningStructuresTable',
    ])
@endsection

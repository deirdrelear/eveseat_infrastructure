@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Alliance Infrastructure: IHUB\'s')
@section('infrastructure_page_header', 'Alliance Infrastructure: IHUB\'s')

@section('infrastructure_content')
    @include('infrastructure::partials.ihub_table', [
        'ihubs' => $ihubs,
        'tableId' => 'allianceIhubsTable',
    ])
@endsection

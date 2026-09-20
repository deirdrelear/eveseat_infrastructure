@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Corporation Infrastructure: IHUB\'s')
@section('infrastructure_page_header', 'Corporation Infrastructure: IHUB\'s')

@section('infrastructure_content')
    @include('infrastructure::partials.ihub_table', [
        'ihubs' => $ihubs,
        'tableId' => 'corporationIhubsTable',
    ])
@endsection

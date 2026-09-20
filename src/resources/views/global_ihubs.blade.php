@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Global Infrastructure: IHUB\'s')
@section('infrastructure_page_header', 'Global Infrastructure: IHUB\'s')

@section('infrastructure_content')
    @include('infrastructure::partials.ihub_table', [
        'ihubs' => $ihubs,
        'tableId' => 'globalIhubsTable',
    ])
@endsection

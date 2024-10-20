@extends('web::layouts.grids.12')

@section('title', @yield('infrastructure_title'))
@section('page_header', @yield('infrastructure_page_header'))

@section('full')
    @yield('infrastructure_content')
@stop

@push('javascript')
    <script src="{{ asset('vendor/infrastructure/js/infrastructure-menu.js') }}"></script>
@endpush
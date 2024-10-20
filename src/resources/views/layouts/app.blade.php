@extends('web::layouts.grids.12')

@push('head')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
@endpush

@section('title')
    @yield('infrastructure_title')
@endsection

@section('page_header')
    @yield('infrastructure_page_header')
@endsection

@section('full')
    @yield('infrastructure_content')
@stop

@push('javascript')
    <script src="{{ asset('vendor/infrastructure/js/infrastructure-menu.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('.table').DataTable();
        });
    </script>
@endpush
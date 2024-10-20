@extends('infrastructure::layouts.app')

@section('infrastructure_title', 'Corporation Infrastructure: IHUB\'s')
@section('infrastructure_page_header', 'Corporation Infrastructure: IHUB\'s')

@section('infrastructure_content')
    @if(count($ihubs) > 0)
        <!-- Сначала выводим табы с именами корпораций -->
        @foreach($corporationNames as $corporationId => $corporationName)
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="{{ $corporationId }}">{{ $corporationName }}</a>
                </li>
            </ul>
        @endforeach

        <!-- Теперь выводим содержимое табов -->
        @foreach($corporationNames as $corporationId => $corporationName)
            <div class="tab-content">
                <div class="tab-pane fade show active" id={{ $corporationId }}>
                    <!-- Выводим таблицу -->
                    <table class="table table-striped table-hover">
                        <!-- Сначала выводим заголовок таблицы -->
                        <thead>
                        <tr>
                            <th scope="col">Solar System</th>
                            <th scope="col">Upgrades</th>
                        </tr>
                        </thead>

                        <!-- Теперь значения -->
                        <tbody>
                        @foreach($ihubs as $ihub)
                            @if($ihub->corporation->corporation_id == $corporationId)
                                <tr>
                                    <td>{{ $ihub->solarSystem->name }}</td>
                                    <td>
                                        @foreach($ihub->upgrades as $upgrade)
                                            {{ $upgrade->upgrade_type->typeName }}<br>
                                        @endforeach
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
@endsection

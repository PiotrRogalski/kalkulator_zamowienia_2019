@extends('layouts.app')

@section('content')

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{--kontrola błędów--}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <ul>
                        <li><a href="/new-task">Nowe zadanie</a></li>
                        <li><a href="/show-task/1">Pokaż zadanie 1</a></li>
                        <li><a href="/all-tasks">Wszystkie zadania</a></li>
                        <li><a href="/settings">Ustawienia</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

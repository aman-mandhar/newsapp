@extends('layouts.dashboard.admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Welcom {{ auth()->user()->name ?? 'Guest' }}</h1>
                @include('partials.all-posts')
            </div>
        </div>
    </div>
@endsection

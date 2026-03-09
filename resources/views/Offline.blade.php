@extends('layouts.portal.view') {{-- ya tumhara main layout name --}}

@section('title', 'Offline')

@section('content')
<div class="container py-5">
    <div class="text-center">
        <h2>आप Offline हैं 😅</h2>
        <p class="text-muted">Internet वापस आते ही page auto काम करेगा.</p>
        <a href="{{ url('/') }}" class="btn btn-success rounded-pill px-4">Home</a>
    </div>
</div>
@endsection

@extends('layouts.portal.view')

@section('title', $user->name . ' - Online Directory Profile')
@section('description', 'View profile of ' . $user->name)
@section('keywords', $user->name . ', directory, skills')

@section('og_title', $user->name . ' Profile')
@section('og_description', 'See detailed profile of ' . $user->name)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Header --}}
            <div class="text-center mb-5">
                <h1 class="fw-bold mb-1">{{ $user->name }}</h1>
                <p class="text-muted mb-0">Profile Overview</p>
            </div>

            {{-- Card --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row">Email</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Mobile</th>
                                    <td>{{ $user->mobile }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

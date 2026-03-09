@extends('layouts.portal.view')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            {{-- Header --}}
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-1">{{ $user->name }}</h2>
                <p class="text-muted mb-0">Profile Overview</p>
            </div>

            {{-- Card --}}
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">

                    {{-- Profile Image + Basic Info --}}
                    <div class="row mb-4">
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
            {{-- Back or Edit --}}
            <div class="text-center mt-4">
                <a href="{{ route('edit.profile') }}" class="btn btn-outline-primary px-4 py-2">✏️ Edit Profile</a>
            </div>
        </div>
    </div>
</div>
@endsection

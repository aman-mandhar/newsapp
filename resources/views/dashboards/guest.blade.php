@extends('layouts.dashboard.guest.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Welcom {{ auth()->user()->name ?? 'Guest' }}</h1>
                <div class="col-lg-9 col-md-8 mb-4">
                    {{-- DIRECTORY CTAs – Polished --}}
                    <style>
                    .action-list .list-group-item{
                        border:1px solid #eee; border-left-width:8px; border-left-style:solid;
                        border-radius:12px; padding:1rem 1rem; display:flex; align-items:center;
                        gap:.9rem; transition:transform .15s ease, box-shadow .15s ease, border-color .15s ease;
                        background:#fff;
                    }
                    .action-list .list-group-item:hover{
                        transform:translateY(-2px);
                        box-shadow:0 10px 22px rgba(0,0,0,.06);
                        text-decoration:none;
                    }
                    .action-list .icon-pill{
                        width:42px; height:42px; border-radius:50%; display:grid; place-items:center;
                        font-size:1.15rem; background:#f4f5f7;
                    }
                    .action-list .label{
                        font-weight:700; color:#111; line-height:1.25;
                    }
                    .action-list .chev{ margin-left:auto; font-weight:700; opacity:.35; transition:transform .2s ease, opacity .2s ease; }
                    .action-list .list-group-item:hover .chev{ transform:translateX(2px); opacity:.6; }

                    /* Accent colors per item (change if you like) */
                    .action-list .list-group-item:nth-child(1){ border-left-color:#0d6efd; } /* blue */
                    .action-list .list-group-item:nth-child(2){ border-left-color:#20c997; } /* teal */
                    .action-list .list-group-item:nth-child(3){ border-left-color:#fd7e14; } /* orange */
                    .action-list .list-group-item:nth-child(4){ border-left-color:#d63384; } /* pink */

                    /* Compact on xs */
                    @media (max-width:576px){
                        .action-list .list-group-item{ padding:.85rem .9rem; }
                        .action-list .icon-pill{ width:38px; height:38px; font-size:1.05rem; }
                    }
                    </style>


                </div>
                    @include('partials.all-posts')
                </div>
            </div>
        </div>
    </div>
@endsection

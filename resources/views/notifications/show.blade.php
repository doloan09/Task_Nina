@extends('layouts.master')

@section('title', 'Quản lý thông báo')

@section('content')
    <div class="container-fluid py-4" style="margin-top: 70px;">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <p class="text-uppercase text-sm" style="font-size: 20px; color: #eea236; margin-bottom: 20px;">{{ $notification->title }}</p>
                        <p>{!! $notification->content !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title','Thank you for Shopping')


@section('content')

<div class="py-3 py-md-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                @if(Session::has('message'))
                   <h5 class="alert alert-success">{{ Session('message') }}</h5>
                @endif
                <div class="p-5 shadow bg-white">
                    <h2>Win Coder</h2>
                    <h4 class="mb-3">Thank You for Shopping with WC-laraecomm</h4>
                    <a href="{{ url('collections') }}" class="btn btn-primary">Shop-now</a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

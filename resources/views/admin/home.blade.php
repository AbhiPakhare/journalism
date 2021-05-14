@extends('layouts.admin.app')
@push('css')
    <style>
        .card {
            border-radius: 10px !important;
        }
    </style>
@endpush
@section('content')
    <div class="justify-content-center fade-in">
{{--        <div class="card">--}}
{{--            <div class="card-body">--}}
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h2>Manager</h2>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h2>Manager</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h2>Manager</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="card">
                            <div class="card-body text-center">
                                <h2>Manager</h2>
                            </div>
                        </div>
                    </div>
                </div>
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection

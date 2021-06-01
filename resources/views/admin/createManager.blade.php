@extends('layouts.admin.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create Manager</h5>
            <form action="{{ route('admin.manager.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="manager name">Name</label>
                    <input type="text" name="name" class="form-control"  placeholder="Enter Name">
                </div>
                @error('name')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror
                <div class="form-group">
                    <label for="manager email">Email</label>
                    <input type="email" name="email" class="form-control"  placeholder="Enter Email">
                </div>
                @error('email')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror
{{--                <div class="form-group">--}}
{{--                    <label for="manager password">Password</label>--}}
{{--                    <input type="password" name="password" class="form-control"  placeholder="Enter Password">--}}
{{--                </div>--}}
{{--                @error('password')--}}
{{--                    <small id="passwordHelpBlock" class="text-danger form-text">--}}
{{--                        {{$message}}--}}
{{--                    </small>--}}
{{--                @enderror--}}
{{--                <div class="form-group">--}}
{{--                    <label for="manager password">Confirm Password</label>--}}
{{--                    <input type="password" name="password_confirmation" class="form-control"  placeholder="Confirm Password">--}}
{{--                </div>--}}
{{--                @error('password_confirmation')--}}
{{--                    <small id="passwordHelpBlock" class="text-danger form-text">--}}
{{--                        {{$message}}--}}
{{--                    </small>--}}
{{--                @enderror--}}
                <button type="submit" class="btn btn-primary">Create Manager</button>
            </form>
        </div>
    </div>
@endsection


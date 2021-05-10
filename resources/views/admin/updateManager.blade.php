@extends('layouts.admin.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update Manager</h5>
            <form action="{{ route('admin.manager.update', [$manager, $manager->id]) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="manager_id" value="{{ $manager->id }}">
                <div class="form-group">
                    <label for="manager name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$manager->name}}"  placeholder="Enter Name">
                </div>
                @error('name')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror
                <div class="form-group">
                    <label for="manager email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{$manager->email}}" placeholder="Enter Email">
                </div>
                @error('email')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror

                <button type="submit" class="btn btn-primary">Update Manager</button>
            </form>
        </div>
    </div>
@endsection


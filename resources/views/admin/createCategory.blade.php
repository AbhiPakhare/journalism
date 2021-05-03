@extends('layouts.admin.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title"> {{__('Create Category')}}</h5>
            <form action="{{ route('admin.category.store') }}" method="POST">
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
                <button type="submit" class="btn btn-primary">Create Category</button>
            </form>
        </div>
    </div>
@endsection


@extends('layouts.admin.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Create Reviewer</h5>
            <form action="{{ route('admin.reviewer.store') }}" method="POST">
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
                <div class="form-group">
                    <label for="manager password">Password</label>
                    <input type="password" name="password" class="form-control"  placeholder="Enter Password">
                </div>
                @error('password')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror
                <div class="form-group">
                    <label for="manager password">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"  placeholder="Confirm Password">
                </div>
                @error('password_confirmation')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror
                <div class="form-group">
                    <label for="Categories">Select Category</label>
                    <select class="form-control custom-select custom-select-lg mb-3" id="categories" name="categories[]" multiple="multiple">
                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                </div>
                @error('categories')
                <small id="passwordHelpBlock" class="text-danger form-text">
                    {{$message}}
                </small>
                @enderror
                <button type="submit" class="btn btn-primary">Create Reviewer</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#categories').select2({
                placeholder: "Select Category",
                allowClear: true,
                cache: true
            });
        });
    </script>
@endpush


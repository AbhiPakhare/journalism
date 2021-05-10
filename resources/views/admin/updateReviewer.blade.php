@extends('layouts.admin.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Update Reviewer</h5>
            <form action="{{ route('admin.reviewer.update', [$reviewer, $reviewer->id]) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- {{ dd($reviewer->id) }} --}}
                <input type="hidden" name="reviewer_id" value = "{{ $reviewer->id }}">
                <div class="form-group">
                    <label for="reviewer name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$reviewer->name}}"  placeholder="Enter Name">
                </div>
                @error('name')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror
                <div class="form-group">
                    <label for="reviewer email">Email</label>
                    <input type="email" name="email" class="form-control" value="{{$reviewer->email}}" placeholder="Enter Email">
                </div>
                @error('email')
                    <small id="passwordHelpBlock" class="text-danger form-text">
                        {{$message}}
                    </small>
                @enderror
                <div class="form-group">
                    <label for="Categories">Select Category</label>
                    <select class="form-control custom-select custom-select-lg mb-3" id="categories" name="categories[]" multiple="multiple">
                        @foreach(App\Category::all() as $category)
                            <option
                            value="{{$category->id}}"
                            {{ ($reviewer->categories->pluck('id')->contains($category->id)) ? 'selected' : '' }}>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('categories')
                <small id="passwordHelpBlock" class="text-danger form-text">
                    {{$message}}
                </small>
                @enderror

                <button type="submit" class="btn btn-primary">Update Reviewer</button>
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

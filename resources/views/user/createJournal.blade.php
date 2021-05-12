@extends('layouts.user.app')
@push('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@endpush
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card ">
      <div class="card-header">
        <h3>File Upload</h3>
      </div>
{{--       
      @if (!empty($journal))
          @foreach ($journal->getMedia() as $media)
              <a href="{{ $media->getUrl() }}">{{ $media->name }} {{ $media }}</a>
          @endforeach
      @endif --}}
      <div class="card-body">
        <form action="{{ route('user.journal.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="form-group">
              <h5 class="card-title">Title</h5>
              <input type="file" id ="title" value="{{ old('title') }}" class="form-control-file" name="title">
            </div>  
            <div class="form-group my-3">
              <h5 class="card-title">Table Content</h5> 
              <input type="file" id="content" class="form-control-file" name="content">
            </div>
            <div class="form-group my-3">
              <h5 class="card-title">Paper Document</h5> 
              <input type="file" id="paper" class="form-control-file" name="paper">
            </div>
            <div class="form-group my-3">
              <h5 class="card-title">Bibliography</h5> 
              <input type="file" id="bibliography" class="form-control-file" name="bibliography">
            </div>
            <div class="form-group my-3">
            <h5 class="card-title">Category</h5>
              <select class="form-control form-control-sm categories"  name="category">
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit Journal</button>

        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@push('scripts')

<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
  <script>
        // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {
      $('#categories').select2({
          placeholder: "Select Category",
          allowClear: true,
          cache: true
      });
  });

  </script>
  <script>

    FilePond.registerPlugin(FilePondPluginFileValidateType);
          FilePond.create(document.querySelector('input[id = "title"]'), {
              acceptedFileTypes: ['application/pdf'],
              required : true,
              allowRevert : false,
              credits :false
          }); 
          FilePond.create(document.querySelector('input[id = "content"]'), {
              acceptedFileTypes: ['application/pdf'],
              required : true,
              allowRevert : false,
              credits :false
          }); 
          FilePond.create(document.querySelector('input[id = "paper"]'), {
              acceptedFileTypes: ['application/pdf'],
              required : true,
              allowRevert : false,
              credits :false
          }); 
          FilePond.create(document.querySelector('input[id = "bibliography"]'), {
              acceptedFileTypes: ['application/pdf'],
              required : true,
              allowRevert : false,  
              credits :false
          }); 

          FilePond.setOptions({
              server: {
                url:'{{ route('user.upload') }}',
                headers:{
                    'X-CSRF-TOKEN':'{{ csrf_token() }}',
                    'Accept' : 'application/json'
                  }
            }
        });
  </script>


@endpush
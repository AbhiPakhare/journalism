@extends('layouts.user.app')
@section('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
  
@endsection
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card ">
      <div class="card-header">
        <h3>File Upload</h3>
      </div>
      <div class="card-body">
        <form action="{{'user.journal.index'}}" method="POST">
          @csrf
            <div class="form-group">
              <h5 class="card-title">Title</h5>
              <input type="file" id ="title" class="form-control-file" name="title">
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
              <select class="form-control form-control-sm abc"  name="category">
                <option>Science, Engineering & Technology</option>
                <option>Arts, Social Science & Humanities</option>
                <option>Physical Sciences & Environment</option>
                <option>Management & Commerce</option>
                <option>Agriculture & Veterinary Science</option>
                <option>Biological & Medical Science</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit Journal</button>

        </form>
      </div>
    </div>
  </div>
</div>

@endsection

@section('script')

<script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
  <script>
        // In your Javascript (external .js resource or <script> tag)
      $(document).ready(function() {
        $('.abc').select2();
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
              credits :false
          }); 
          FilePond.create(document.querySelector('input[id = "paper"]'), {
              acceptedFileTypes: ['application/pdf'],
              credits :false
          }); 
          FilePond.create(document.querySelector('input[id = "bibliography"]'), {
              acceptedFileTypes: ['application/pdf'],
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


@endsection
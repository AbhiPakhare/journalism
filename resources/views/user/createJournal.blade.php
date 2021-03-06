@extends('layouts.user.app')
@push('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
  <style>
	  .mandatory{
		  color: red;
	  }
  </style>
@endpush
@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card ">
      <div class="card-header">
        <h3>File Upload</h3>
      </div>

      <div class="card-body">
          <div class="rules">
              <ul>
                  <li>Feilds with <span class="mandatory">*</span> this are mandatory.</li>
                  <li>All the file should be of .pdf or .doc or .docx extension.</li>
                  <li>Each file size should be less than 5MB.</li>
              </ul>
          </div>
        <form action="{{ route('user.journal.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="form-group">
                <div class="row">
                    <h5 class="card-title" style="margin-left: 14px">Title <span class="mandatory">*</span></h5> <a href="{{URL::asset('sample/Title.pdf')}}" target="_blank" style="margin-left: 7px">Sample Title</a>
                </div>

              <input type="file" id ="title" value="{{ old('title') }}" class="form-control-file" name="title">
            </div>
            <div class="form-group my-3">
              <h5 class="card-title">Table Content <span class="mandatory">*</span></h5>
              <input type="file" id="content" class="form-control-file" name="content">
            </div>
            <div class="form-group my-3">
              <h5 class="card-title">Paper Document <span class="mandatory">*</span></h5>
              <input type="file" id="paper" class="form-control-file" name="paper">
            </div>
            <div class="form-group my-3">
              <h5 class="card-title">Bibliography <span class="mandatory">*</span></h5>
              <input type="file" id="bibliography" class="form-control-file" name="bibliography">
            </div>
            <div class="form-group my-3">
            <h5 class="card-title">Category <span class="mandatory">*</span></h5>
				<select class="form-control form-control-sm categories @error('category') is-invalid @enderror"  name="category">
					@foreach ($categories as $category)
						<option value="{{ $category->id }}">{{ $category->name }}</option>
					@endforeach
				</select>
            </div>
            @error('category')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <button type="submit" class="btn btn-primary btn-lg btn-block">Submit Journal</button>
        </form>
      </div>
    </div>

@endsection

@push('scripts')

    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
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
            acceptedFileTypes: [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            fileValidateTypeLabelExpectedTypesMap : {
                'application/pdf' : "pdf",
                'application/msword' : "doc",
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' : "docx"
            },
            required : true,
            allowRevert : false,
            credits :false,
            labelIdle :"Upload <strong>Title</strong> in PDF or Word file<span class='filepond--label-action'> Browse </span>"
        });
        FilePond.create(document.querySelector('input[id = "content"]'), {
            acceptedFileTypes: [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            fileValidateTypeLabelExpectedTypesMap : {
                'application/pdf' : "pdf",
                'application/msword' : "doc",
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' : "docx"
            },
            required : true,
            allowRevert : false,
            credits :false,
            labelIdle :"Upload <strong>Content</strong> in PDF or Word file<span class='filepond--label-action'> Browse </span>"
        });
        FilePond.create(document.querySelector('input[id = "paper"]'), {
            acceptedFileTypes: [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            fileValidateTypeLabelExpectedTypesMap : {
                'application/pdf' : "pdf",
                'application/msword' : "doc",
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' : "docx"
            },
            required : true,
            allowRevert : false,
            credits :false,
            labelIdle :"Upload <strong>Paper Document</strong> in PDF or Word file<span class='filepond--label-action'> Browse </span>"
        });
        FilePond.create(document.querySelector('input[id = "bibliography"]'), {
            acceptedFileTypes: [
                'application/pdf',
                'application/msword',
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
            ],
            fileValidateTypeLabelExpectedTypesMap : {
                'application/pdf' : "pdf",
                'application/msword' : "doc",
                'application/vnd.openxmlformats-officedocument.wordprocessingml.document' : "docx"
            },
            required : true,
            allowRevert : false,
            credits :false,
            labelIdle :"Upload <strong>Bibliography</strong> in PDF or Word file<span class='filepond--label-action'> Browse </span>"
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

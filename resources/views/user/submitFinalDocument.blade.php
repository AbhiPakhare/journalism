@extends('layouts.user.app')
@push('css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card ">
                <div class="card-header">
                    <h3>Final Upload Document</h3>
                </div>
                <div class="card-body">
                    <div class="rules">
                        <ul>
                            <li>All the file should be of .pdf or .doc or .docx extension.</li>
                        </ul>
                    </div>
                    <form action="{{ route('user.store-final-doc') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $journal->id }}">
                        <div class="form-group my-3">
                            <input type="file" id="final-document" class="form-control-file" name="final_document">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                    </form>
                </div>
            </div>

            @endsection

            @push('scripts')

                <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
                <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
                <script>

                    FilePond.registerPlugin(FilePondPluginFileValidateType);
                    FilePond.create(document.querySelector('input[id = "final-document"]'), {
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
                        labelIdle :"Upload <strong>Final Document</strong> in PDF or Word file<span class='filepond--label-action'> Browse </span>"
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

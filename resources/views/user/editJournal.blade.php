@extends('layouts.user.app')
@push('css')
  <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet" />
@endpush
@section('content')
<div class="row justify-content-center">
	<div class="col-md-6">
		<div class="card">
			<div class="card-header">Re Submit Journal :  {{ $journal->reference_id }}</div>
			<div class="card-body">
				<div class="card-title">
					Reason: {{ $journal->reason }}
				</div>
				<form action="{{ route('user.journal.update', [$journal]) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="form-group my-3">
						<h5 class="card-title">Paper Document</h5> 
						<input type="file" id="paper" class="form-control-file" name="paper">
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
	FilePond.create(document.querySelector('input[id = "paper"]'), {
		acceptedFileTypes: ['application/pdf'],
		// required : true,
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
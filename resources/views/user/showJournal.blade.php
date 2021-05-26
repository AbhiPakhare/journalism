@extends('layouts.user.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
                <div class="col-md-12">
                    @if($errors->any())
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger" role="alert">
                                {{$error}}
                            </div>
                        @endforeach
                    @endif
                </div>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
				@if ($journals->count() > 0)
					<table class="table table-bordered text-center">
						<thead class="table-dark">
						<tr>
							<th scope="col">Id</th>
							<th scope="col">Reference Id</th>
							<th scope="col">Category</th>
							<th scope="col">Submitted on</th>
							<th scope="col">Status</th>
							@if ($status == "pending" || $status == "rejected")
								<th scope="col">Reason</th>
							@endif
							@if ($status == "pending")
								<th scope="col">Action</th>
							@endif
						</tr>
						</thead>
						<tbody >
							@foreach ($journals as $journal )
								<tr>
									<th scope="row">{{ $loop->iteration }}</th>
									<td>{{ $journal->reference_id }}</td>
									<td>{{ $journal->categories[0]->name }}</td>
									<td>{{ date('d-M-Y', strtotime($journal->created_at))  }}</td>
									
									@if ( $journal->status == "Waiting" )
									
									<td class="table-info text-dark">{{ $journal->status }}</td>
									
									@elseif ( $journal->status == "Approved" )
									
									<td class="table-success">{{ $journal->status }}</td>
									@elseif ( $journal->status == "Pending" )
									
									<td class="table-warning">{{ $journal->status }}</td>
									
									@elseif ( $journal->status == "Rejected" )
									<td class="table-danger">{{ $journal->status }}</td>
									@endif
									@if ($status == "pending" || $status == "rejected")
										<td>
											<button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal-{{$loop->iteration}}">
												Reason
											</button>
											<div class="modal fade" id="exampleModal-{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Reason for Journal : {{$journal->reference_id}}</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															{{$journal->reason}}
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														</div>
													</div>
												</div>
											</div>
										</td>
									@endif
									@if  ($status == "pending")
										<td>
											<a href="{{ route('user.journal.edit', [$journal]) }}" class="btn btn-primary text-white">Re-Submit</a>
									@endif
								</tr>

							@endforeach
						</tbody>
					</table>
				@else
					@if ($status == "pending")
						No Journals for re submission.
					@elseif ($status == "rejected")
						No Journals Rejected
					@else
						No journals for submmitted
					@endif
				@endif
			</div>
		</div>
	</div>
</div>
  {{ $journals->links() }}
@endsection

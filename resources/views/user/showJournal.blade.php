@extends('layouts.user.app')

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				@if ($journals->count() > 0)
					<table class="table table-bordered text-center">
						<thead class="table-dark">
						<tr>
							<th scope="col">Id</th>
							<th scope="col">Reference Id</th>
							<th scope="col">Category</th>
							<th scope="col">Submitted on</th>
							<th scope="col">Status</th>
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
										@if ($status == "pending")
											<td>
												<a href="{{ route('user.journal.edit', [$journal]) }}" class="btn btn-primary text-white">Re-Submit</a>
											</td>
										@endif
								</tr>

							@endforeach
						</tbody>
					</table>
				@else
					@if ($status == "pending")
						No Journals for re submission.
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

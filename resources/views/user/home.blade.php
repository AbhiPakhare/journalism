@extends('layouts.user.app')

@push('css')
<style>
	.card {
		background-color: #ffffff4a  !important;
	}
  .progressbar {
      counter-reset: step;
  }
  .progressbar li {
      list-style-type: none;
      width: 10%;
      float: left;
      font-size: 12px;
      position: relative;
      text-align: center;
      /* color: #7d7d7d; */
      color: #7d7d7d;
  }
  .progressbar li:before {
      width: 30px;
      height: 30px;
      content: counter(step);
      counter-increment: step;
      line-height: 30px;
      border: 2px solid #7d7d7d;
      display: block;
      text-align: center;
      margin: 0 auto 10px auto;
      border-radius: 50%;
      background-color: white;
  }
  .progressbar li:after {
      width: 100%;
      height: 2px;
      content: '';
      position: absolute;
      background-color: gray;
      top: 15px;
      left: -50%;
      z-index: -1;
  }
  .progressbar li:first-child:after {
      content: none;
  }
  .progressbar li.active {
      color: green !important;
  }
  .progressbar li.active:before {
      border-color: #55b776 !important;
  }
  .progressbar li.active + li:after {
      background-color: #55b776 !important;
  }
</style>
@endpush
@section('content')
<div class="card">
	<div class="card-body">
		@if ($journals->count())
			<table class="table table-bordered table-striped text-center">
				<thead >
					<tr class="thead-dark">
						<th>#</th>
						<th>Reference Id</th>
						<th>Journey Status</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach ($journals as $journal )
					<tr >
							<td>{{ $loop->iteration }}</td>
							<td>{{ $journal->reference_id }}</td>
							<td>
								<ul class="progressbar">
									<li class="active">Submitted</li>
									<li 
										class = "{{ $journal->journey_status['stage'] >= 1 ? "active" : "false" }}"
									>
										Checking process
									</li>
									<li 
										class="{{ $journal->journey_status['stage'] >= 2 ? "active" : "false" }}"
									>
										@if ($journal->journey_status['stage'] > 2)
											Status(Approved)
										@elseif($journal->journey_status['stage'] == 2)
											Status({{ $journal->journey_status['stage_name'] }})
										@else
											Status
										@endif
									</li>
									<li 
										class="{{ $journal->journey_status['stage'] >= 3 ? "active" : "false" }}"
									>
										@if ($journal->journey_status['stage'] > 3)
											Payment(Approved)
										@elseif($journal->journey_status['stage'] == 3)
											Payment({{ $journal->journey_status['stage_name'] }})
										@else
											Payment
										@endif
										
									</li>
									<li
										class="{{ $journal->journey_status['stage'] == 4 ? "active" : "false" }}"
										>
										@if ($journal->journey_status['stage'] == 4 )
											{{ $journal->journey_status['stage_name'] }}
										@else
											Final Document upload
										@endif
									</li>
								</ul>
							</td>
						</tr>
					@endforeach

				</tbody>
			</table>
			{{ $journals->links() }}
		@else
			<h4>No Jouranls submitted</h4>
		@endif
	</div>
</div>

@endsection
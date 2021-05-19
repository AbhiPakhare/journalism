@extends('layouts.admin.app')
@push('css')
<style>
	.card{
		background-color: #F5F5F5;
	}
	.card-header{
		background-color: #d9d9d9;
	}
</style>

@endpush
@section('content')

	<div class="card">
		<div class="card-header">
			User Stats
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<div class="card text-white mb-3" style=" background-color: #3b707d" >
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['all_users'] ?? '0' }}
							</div>
							<p class="text">All users</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="card text-white mb-3" style="background-color: #74BDCB">
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['managers_count'] ?? '0' }}
							</div>

							<p class="text">Managers</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="card text-white mb-3" style=" background-color: #65A9A6">
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['reviewers_count'] ?? '0' }}
							</div>
							<p class="text">Reviewers</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="card text-white mb-3" style="background-color: #23424A">
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['users_count'] ??'0' }}
							</div>
							<p class="text">Users</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header" >
			Journal Stats
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-md-3 col-sm-6">
					<div class="card text-white mb-3" style="background-color: #123175">
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['all_journals'] ?? '0' }}
							</div>
							<p class="text">Total submitted</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="card text-white bg-success mb-3">
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['approved_journals'] ?? '0' }}
							</div>
							<p class="text">Approved</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="card text-white bg-warning mb-3">
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['waiting_journals'] ??'0' }}
							</div>
							<p class="text">Waiting</p>
						</div>
					</div>
				</div>
				<div class="col-md-3 col-sm-6">
					<div class="card text-white bg-danger mb-3">
						<div class="card-body">
							<div class="text-value-lg ">
								{{ $data['rejected_journals'] ?? '0' }}
							</div>

							<p class="text">Rejected</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		{{-- Last month waiting --}}

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					Last Month Waiting Statistics of Journals
				</div>
				<div class="card-body">
					<div style="height: 500px">
						<canvas id="myChartOneMonth"></canvas>
					</div>
				</div>
			</div>
		</div>

		{{-- Last month approved --}}

		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					Last Month Approved statistics of Journals
				</div>
				<div class="card-body">
					<div style="height: 500px">
						<canvas id="myChartOneMonthApproved"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- Last month rejected --}}

	<div class="row">
		<div class="col-md-12">
			<div class="card">
				<div class="card-header">
					Last Month Rejected Statistics of journals
				</div>
				<div class="card-body">
					<div style="height: 500px">
						<canvas id="lastOneMonthRejected"></canvas>
					</div>
				</div>
			</div>
		</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
	//waiting	
	var waitingURL = "{{ route('admin.journals-waiting') }}";
	var dates = new Array();
	var counts = new Array();
	$(document).ready(function(){
		$.get(waitingURL, function(waitingResponse){
		Object.keys(waitingResponse).forEach(function(key){
			dates.push(key);
			counts.push(waitingResponse[key]);
		});
		var ctx = document.getElementById("myChartOneMonth").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: dates,
					datasets: [
						{
						label: 'Waiting',
						data: counts,
						backgroundColor: [
							'rgba(255, 159, 64, 0.2)'
						],
						borderColor: [
							'rgba(255, 159, 64, 1)'
						],
						borderWidth: 1
					}]
				},
				options: {
				responsive: true,
    			maintainAspectRatio: false,
				scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		});
	});


	//approved
	const approvedURL = "{{ route('admin.journals-approved') }}";
	var approvedDates = new Array();
	var approvedCounts = new Array();
	$(document).ready(function(){

		$.get(approvedURL, function(response){

		Object.keys(response).forEach(function(key){
			approvedDates.push(key);
			approvedCounts.push(response[key]);
		});
		var ctx = document.getElementById("myChartOneMonthApproved").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: approvedDates,
					datasets: [
						{
						label: 'Approved',
						data: approvedCounts,
						backgroundColor: [
							'rgba(75, 192, 192, 0.2)',
						],
						borderColor: [
							'rgba(75, 192, 192, 1)',
						],
						borderWidth: 1
					}]
				},
				options: {
				responsive: true,
    			maintainAspectRatio: false,
				scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		});
	});



	//rejected	
	var rejectedURL = "{{ route('admin.journals-rejected') }}";
	var rejectedDates = new Array();
	var rejectedCounts = new Array();
	$(document).ready(function(){
		$.get(rejectedURL, function(rejectedResponse){
		Object.keys(rejectedResponse).forEach(function(key){
			rejectedDates.push(key);
			rejectedCounts.push(rejectedResponse[key]);
		});
		var ctx = document.getElementById("lastOneMonthRejected").getContext('2d');
			var myChart = new Chart(ctx, {
				type: 'bar',
				data: {
					labels: rejectedDates,
					datasets: [
						{
						label: 'Rejected',
						data: rejectedCounts,
						backgroundColor: [
							'rgba(255, 99, 132, 0.2)',
						],
						borderColor: [
							'rgba(255, 99, 132, 1)',
						],
						borderWidth: 1
					}]
				},
				options: {
				responsive: true,
    			maintainAspectRatio: false,
				scales: {
						yAxes: [{
							ticks: {
								beginAtZero:true
							}
						}]
					}
				}
			});
		});
	});

</script>
@endpush

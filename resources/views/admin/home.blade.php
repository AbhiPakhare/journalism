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
							<p class="text">Warning</p>
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
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					One Month Statistics
				</div>
				<div class="card-body">
					<h5 class="card-title">Journals</h5>
					<div>
						<canvas id="myChartOneMonth"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					Three months Statistics
				</div>
				<div class="card-body">
					<h5 class="card-title">Journal 3 Months</h5>
					<div>
						<canvas id="myChartThreeMonth"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					Six Month Statistics
				</div>
				<div class="card-body">
					<h5 class="card-title">Journals</h5>
					<div>
						<canvas id="myChartSixMonth"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card">
				<div class="card-header">
					One Year Statistics
				</div>
				<div class="card-body">
					<h5 class="card-title">Journal 1 Year</h5>
					<div>
						<canvas id="myChartOneYear"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
        var url = "{{ route('admin.test')}}";
        var Years = new Array();
        var Labels = new Array();
        var Prices = new Array();
        $(document).ready(function(){
          $.get(url, function(response){
            response.data.forEach(function(data){
                Years.push(data.reference_id);
            });
            var ctx = document.getElementById("myChartOneMonth").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:Years,
                      datasets: [{
                          label: 'Infosys Price',
                          data: Prices,
                          borderWidth: 1
                      }]
                  },
                  options: {
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
<script>
// var ctx = document.getElementById('myChartOneMonth');
// var myChartOneMonth = new Chart(ctx, {
//     type: 'bar',
//     data: {
//         labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange','abc'],
//         datasets: [{
//             label: 'submitted Journal with last one month',
//             data: [12, 19, 3, 5, 2, 3,40.6],
//             backgroundColor: [
//                 'rgba(255, 99, 132, 0.2)',
//                 'rgba(54, 162, 235, 0.2)',
//                 'rgba(255, 206, 86, 0.2)',
//                 'rgba(75, 192, 192, 0.2)',
//                 'rgba(153, 102, 255, 0.2)',
//                 'rgba(255, 159, 64, 0.2)'
//             ],
//             borderColor: [
//                 'rgba(255, 99, 132, 1)',
//                 'rgba(54, 162, 235, 1)',
//                 'rgba(255, 206, 86, 1)',
//                 'rgba(75, 192, 192, 1)',
//                 'rgba(153, 102, 255, 1)',
//                 'rgba(255, 159, 64, 1)'
//             ],
//             borderWidth: 1
//         }]
//     },
//     options: {
//         scales: {
//             y: {
//                 beginAtZero: true
//             }
//         }
//     }
// });
var ctx = document.getElementById('myChartThreeMonth');
var myChartThreeMonth = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange','abc'],
        datasets: [{
            label: 'submitted Journal with last three months',
            data: [12, 19, 3, 5, 2, 3,40.6],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
var ctx = document.getElementById('myChartSixMonth');
var myChartSixMonth = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange','abc'],
        datasets: [{
            label: 'submitted Journal with last six months',
            data: [12, 19, 3, 5, 2, 3,40.6],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
var ctx = document.getElementById('myChartOneYear');
var myChartOneYear = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange','abc'],
        datasets: [{
            label: 'submitted Journal with last one year',
            data: [12, 19, 3, 5, 2, 3,40.6],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endpush

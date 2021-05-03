@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List of Categories
                </h4>
            </div>
            <a href="{{route('admin.category.create')}}" class="btn btn-primary mt-3 mb-4">Create Category</a>


            <table class="table table-borderless" id="datatable">
                <thead class="thead-dark">
                <tr>
                    <th>Name</th>
                    <th>action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>

    <script>
        $(document).ready( function () {

            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                responsive : true,
                "ajax": "{{ route('admin.list-of-categories') }}",
                "columns": [
                    {data: 'name', name: 'name'}, // index 0
                    {data: 'action', name: 'action'}
                ],
                'columnDefs': [ {
                    'targets': [0,1], /* column index */
                    'orderable': false, /* true or false */
                }]

            });
        });

    </script>
@endsection

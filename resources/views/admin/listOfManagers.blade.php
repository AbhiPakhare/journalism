@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List of Managers
                </h4>
            </div>
            <table class="table table-borderless" id="datatable">
                <thead class="thead-dark">
                <tr>
                    <th>name</th>
                    <th>email</th>
                    <th>role</th>
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
                "ajax": "{{ route('admin.list-of-managers') }}",
                "columns": [
                    {data: 'name', name: 'name'}, // index 0
                    {data: 'email', name: 'email'}, // index 1
                    {data: 'role', name: 'role'}, // index 2
                    {data: 'action', name: 'action'}
                ],
                'columnDefs': [ {
                    'targets': [0,1,2], /* column index */
                    'orderable': false, /* true or false */
                }]

            });
        });

    </script>
@endsection

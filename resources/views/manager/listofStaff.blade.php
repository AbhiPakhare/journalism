@extends('layouts.manager.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List of Staff
                </h4>
            </div>
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>Name Of Staff</th>
                        <th>Email</th>
                        <th>Category</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Name of Staff</th>
                    <th>Email</th>
                    <th>Category</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready( function () {
            $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                "lengthMenu": [10],
                responsive : true,
                "ajax": "{{ route('manager.list-of-staffs') }}",
                "columns": [
                    {data: 'name', name: 'name'}, // index 0
                    {data: 'email', name: 'email'}, // index 1
                    {data: 'categories', name: 'categories'}, // index 2
                    {data: 'role', name: 'role'}, // index 3
                ],
                initComplete: function () {
                    this.api().columns().every(function () {
                        var column = this;
                        var input = document.createElement("input");
                        input.placeholder = "Search by Column"
                        $(input).appendTo($(column.footer()).empty())
                        .on('change', function () {
                            column.search($(this).val()).draw();
                        });
                    });
                },
                'columnDefs': [ {
                    'targets': [0,1,2,3], /* column index */
                    'orderable': false, /* true or false */
                }]

            });
        });
    </script>
@endpush

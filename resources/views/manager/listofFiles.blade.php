@extends('layouts.manager.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List of Files
                </h4>
            </div>
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>Reference No</th>
                        <th>Categories</th>
                        <th>Submitted on</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Reference No</th>
                    <th>Categories</th>
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
                "bLengthChange" : false,
                "serverSide": true,
                responsive : true,
                "ajax": "{{ route('manager.list-of-files') }}",
                "columns": [
                    {data: 'reference_id', name: 'reference_id'}, // index 0
                    {data: 'categories', name: 'categories'}, // index 1
                    {data: 'created_at', name: 'created_at'},//index 2
                    {data: 'action', name: 'action'}, // index 3
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
                    'targets': [0,1,2], /* column index */
                    'orderable': false, /* true or false */
                }]

            });
        });

    </script>
@endpush

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
                        <th>Name Of Files</th>
                        <th>Reference_No.</th>
                        <th>Categories</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Name of Files</th>
                    <th>Reference_No.</th>
                    <th>Categories</th>
                    <th>Action</th>
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
                "lengthMenu": [10],
                "serverSide": true,
                responsive : true,
                "ajax": "{{ route('manager.list-of-files') }}",
                "columns": [
                    {data: 'File Name', name: 'File Name'}, // index 0
                    {data: 'reference_id.', name: 'reference_id.'}, // index 1
                    {data: 'categories', name: 'categories'}, // index 2
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
                    'targets': [0,1,2,3], /* column index */
                    'orderable': false, /* true or false */
                }]

            });
        });

    </script>
@endpush

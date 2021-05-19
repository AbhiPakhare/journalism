@extends('layouts.admin.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List of Approved Journals
                </h4>
            </div>
            <table class="table " id="datatable">
                <thead>
                    <tr>
                        <th>Reference No</th>
                        <th>Status</th>
                        <th>Categories</th>
                        <th>Submitted By</th>
                        <th>Submitted On</th>
                        <th>Reviewed By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>Reference No</th>
                    <th>Status</th>
                </tr>
                </tfoot>
            </table>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready( function () {
           let oTable =  $('#datatable').DataTable({
                "processing": true,
                "bLengthChange" : false,
                "serverSide": true,
                responsive : true,
                "ajax": "{{ route('admin.approved-journals') }}",
                "columns": [
                    {data: 'reference_id', name: 'reference_id'}, // index 0
                    {data: 'status', name: 'status'},//index 1
                    {data: 'categories', name: 'categories'}, // index 2
                    {data: 'user.name', name: 'user.name'}, // index 3
                    {data: 'created_at', name: 'created_at'},//index 4
                    {data: 'reviewer.name', name: 'reviewer.name'}, // index 5
                    {data: 'action', name: 'action'}, // index 6
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
                    'targets': [0,1,2,3,5,6], /* column index */
                    'orderable': false, /* true or false */
                }]

            });
        });
    </script>
@endpush

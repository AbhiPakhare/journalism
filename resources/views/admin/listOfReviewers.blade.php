@extends('layouts.admin.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List of Reviewers
                </h4>
            </div>
            <a href="{{route('admin.reviewer.create')}}" class="btn btn-primary mt-3 mb-4">Create Reviewer</a>

            <table class="table " id="datatable">

                <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Categories</th>
                    <th>Created at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th>name</th>
                    <th>email</th>
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
                "bLengthChange" : false,
                "lengthMenu": [10],
                "processing": true,
                "serverSide": true,
                responsive : true,
                "ajax": "{{ route('admin.list-of-reviewers') }}",
                "columns": [
                    {data: 'name', name: 'name'}, // index 0
                    {data: 'email', name: 'email'}, // index 1
                    {data: 'role', name: 'role'}, // index 2
                    {data: 'categories', name: 'categories'}, // index 3
                    {data: 'created_at', name: 'created_at'},//index 4
                    {data: 'action', name: 'action'}, // index 5
                ],
                order: [[4, 'asc']],
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
                    'targets': [0,1,2,4], /* column index */
                    'orderable': false, /* true or false */
                }]

            });

            $('#datatable').on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();

                let confirmed = confirm("Are Your sure");
                if (confirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        }
                    });
                    var url = $(this).data('remote');
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        dataType: 'json',
                        data: {method: '_DELETE', submit: true}
                    }).always(function (data) {
                        $('#datatable').DataTable().draw(false);
                    });
                }
            });
        });

    </script>
@endpush

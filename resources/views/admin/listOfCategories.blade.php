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


            <table class="table" id="datatable">
                <thead>
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
@endsection
@push('scripts')
    <script>
        $(document).ready( function () {

            $('#datatable').DataTable({
                "bLengthChange" : false,
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
@endpush

@extends('layouts.manager.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List Of Submitted Journals
                </h4>
            </div>
            @if ($journals->count() > 0)
                <form class="form-inline" action="{{ route('manager.list-of-files') }}" method="GET">
                    <div class="form-group mb-2">
                        <label for="exampleFormControlSelect1 mr-2">Sort by categories: </label>
                        <select class="form-control ml-2" id="exampleFormControlSelect1" name="categories">
                        <option value="clear">--Select Category--</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id ?? old($category->id) }}">{{ $category->name }}</option>
                        @endforeach
                        </select>
                        <button class="btn btn-primary mb-2 mt-2 ml-4" type="submit">Search</button>
                        <a class="btn btn-info mx-sm-4 mb-2 mt-2" href="{{route('manager.list-of-files')}}">Reset</a>
                    </div>
                </form>
                <table class="table " id="datatable">
                    <thead>
                        <tr>
                            <th>Reference No</th>
                            <th>Status</th>
                            <th>Categories</th>
                            <th>Submitted By</th>
                            <th>Submitted on</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($journals as $journal)
                        <tr>
                            <td>{{ $journal->reference_id }}</td>
                            <td>{{ $journal->status }}</td>
                            <td>{{ $journal->categories[0]->name }}</td>
                            <td>{{ $journal->user->name }}</td>
                            <td>{{ date('d-M-Y', strtotime($journal->created_at)) }}</td>
                            <td>
                                <a 
                                    href="{{ (isset($journal->getMedia()[2])) ? $journal->getMedia()[2]->getUrl() : "No paper uploaded" }}" 
                                    class="btn btn-info"
                                    target="_blank">
                                    View Paper
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    {{-- <tfoot>
                    <tr>
                        <th>Reference No</th>
                        <th>Status</th>
                    </tr>
                    </tfoot> --}}
                </table>
            @else
                No Journals submitted.
            @endif
            <div class="paginate ml-2">
				{{$journals->links()}}
			</div>
        </div>

    </div>
@endsection

{{-- @push('scripts')
    <script>
        $(document).ready( function () {
           let oTable =  $('#datatable').DataTable({
                "processing": true,
                "bLengthChange" : false,
                "serverSide": true,
                responsive : true,
                "ajax": "{{ route('manager.list-of-files') }}",
                "columns": [
                    {data: 'reference_id', name: 'reference_id'}, // index 0
                    {data: 'status', name: 'status'},//index 1
                    {data: 'categories', name: 'categories'}, // index 2
                    {data: 'user.name', name: 'user.name'}, // index 3
                    {data: 'created_at', name: 'created_at'},//index 4
                    {data: 'action', name: 'action'}, // index 5
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
                    'targets': [0,1,2,3,5], /* column index */
                    'orderable': false, /* true or false */
                }]

            });
        });
    </script>
@endpush --}}

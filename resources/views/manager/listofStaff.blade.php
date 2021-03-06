@extends('layouts.manager.app')
@push('css')
    <style>

    </style>
@endpush

@section('content')

<div class="card">
    <div class="class-body">
        <div class="card-header">
            <h4>
                List of Staff
            </h4>
        </div>
        <div class="row pl-3">
            <div class="col-md-6">
                <form class="form-inline" action="{{ route('manager.show-staffs') }}" method="GET">
                    <div class="form-group mb-2">
                        <label for="exampleFormControlSelect1 mr-2">Sort by categories: </label>
                        <select class="form-control ml-2" id="exampleFormControlSelect1" name="categories">
                          <option value="clear">--Select Category--</option>
                          @foreach ($categories as $category)
                            <option value="{{ $category->id ?? old($category->id) }}">{{ $category->name }}</option>
                          @endforeach
                        </select>
                        <button class="btn btn-primary mb-2 mt-2 ml-4" type="submit">Search</button>
                        <a class="btn btn-info mx-sm-4 mb-2 mt-2" href="{{route('manager.show-staffs')}}">Reset</a>
                      </div>
                </form>
            </div> 
        </div>
        <table class="table table-hover">
            <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name Of Staff</th>
                  <th scope="col">Email</th>
                  <th scope="col">Category</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($reviewers as $reviewer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $reviewer->name }}</td>
                        <td>{{ $reviewer->email }}</td>
                        <td>{{ $reviewer->categories ? implode(', ',$reviewer->categories->pluck('name')->toArray()) :"asdsadas" }}</td>
                    </tr>
                @endforeach

              </tbody>
        </table>
        <div class="paginate ml-2">
            {{$reviewers->links()}}
        </div>
    </div>
</div>
    {{-- <div class="card">
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
    </div> --}}
@endsection

{{-- @push('scripts')
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
@endpush --}}

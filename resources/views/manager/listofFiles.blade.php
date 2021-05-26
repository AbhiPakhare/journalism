@extends('layouts.manager.app')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="card-header">
                <h4 >
                    List Of Submitted Journals
                </h4>
            </div>
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
            @if ($journals->count() > 0)
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
                                    href="{{ (isset($journal->getMedia()[3])) ? $journal->getMedia()[3]->getUrl() : "No paper uploaded" }}"
                                    class="btn btn-info"
                                    target="_blank">
                                    View Paper
                                </a>
                                <a
                                    href="{{ (isset($journal->getMedia()[0])) ? $journal->getMedia()[0]->getUrl() : "No Title uploaded" }}"
                                    class="btn btn-info"
                                    target="_blank">
                                    View Title
                                </a>
                                <a
                                    href="{{ route('manager.show-journal',[$journal->id]) }}"
                                    class="btn btn-info">
                                    Assign
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
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

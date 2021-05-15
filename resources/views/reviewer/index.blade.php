@extends('layouts.reviewer.app')

@section('content')
    <div class="card">
            <div class="card-header">
                <h5>
                    list of Journals
                </h5>
            </div>
        <div class="card-body ">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Reference Id</th>
                    <th scope="col">Submitted on</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody >
                @foreach ($journals as $journal )
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $journal->reference_id }}</td>
                        <td>{{ date('d-M-Y', strtotime($journal->created_at))  }}</td>
                        <td>
                            @if(!empty($journal->getMedia()[3]->getUrl()))
                                <a href="{{$journal->getMedia()[3]->getUrl()}}" target="_blank" class="btn btn-primary text-white">View Paper</a>
                            @endif
                            <a href="{{route('reviewer.journal.edit', $journal)}}" class="btn btn-info" >Check Journal</a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

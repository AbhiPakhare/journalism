@extends('layouts.reviewer.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h5>
                list of Journals
            </h5>
        </div>
        <div class="card-body">
            @if($journals->count())
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
                                @if(!empty($journal->getMedia()))
                                    <a href="{{!empty($journal->getMedia()[3]) ? $journal->getMedia()[3]->getUrl():''}}" target="_blank" class="btn btn-primary text-white">View Paper</a>
                                @endif
                                @if(in_array($journal->status, ['Waiting', 'Rejected']) && !empty($journal->reason))
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal-{{$loop->iteration}}">
                                        Reason
                                    </button>
                                        <div class="modal fade" id="exampleModal-{{$loop->iteration}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Reason for Journal : {{$journal->reference_id}}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        {{$journal->reason}}
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-primary" role="alert">
                    @if($status == "approved")
                        You have not approved any journal
                    @elseif($status == "rejected")
                        You have not rejected any journal
                    @elseif($status == "waiting")
                        No journals are in waiting from your end
                    @endif
                </div>
            @endif
            {{$journals->links()}}
        </div>
    </div>
@endsection

@extends('layouts.user.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered text-center">
                    <thead class="table-dark" >
                      <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Reference Id</th>
                        <th scope="col">Submitted on</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody >
                        @foreach ($journals as $journal )
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $journal->reference_id }}</td>
                                <td>{{ date('d-M-Y', strtotime($journal->created_at))  }}</td>

                                @if ( $journal->status == "Waiting" )

                                    <td class="table-info text-dark">{{ $journal->status }}</td>

                                @elseif ( $journal->status == "Approved" )

                                    <td class="table-success">{{ $journal->status }}</td>

                                @elseif ( $journal->status == "Rejected" )
                                    <td class="table-danger">{{ $journal->status }}</td>
                                @endif
                            </tr>
                
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
  {{ $journals->links() }}
@endsection
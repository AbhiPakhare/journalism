@extends('layouts.admin.app')

@section('content')
        <div class="accordion" id="accordionExample">
            @forelse($users as $user )
                <div class="card card-accent-info">
                    <div
                        class="card-header"
                        id="heading{{ $loop->iteration }}"
                        style="display: flex; justify-content:space-between; align-items:center"
                        data-toggle="collapse"
                        data-target="#collapse{{ $loop->iteration }}"
                        aria-expanded="true"
                        aria-controls="collapse{{ $loop->iteration }}"
                    >
                    <div>
                        <dl class="row">
                            <dt class="col-sm-3">Name</dt>
                            <dd class="col-sm-9"> {{ $user->name }}</dd>

                            <dt class="col-sm-3">Email</dt>
                            <dd class="col-sm-9"> {{ $user->email }} </dd>

                            <dt class="col-sm-3">Contact No</dt>
                            <dd class="col-sm-9">{{ $user->phone->phone_number ?? "No number provided" }}</dd>

                            <dt class="col-sm-3 text-truncate">Journal Submitted</dt>
                            <dd class="col-sm-9">{{ $user->journal_count }}</dd>
                        </dl>
                    </div>
                                <i class="fas fa-chevron-down"></i>
                    </div>

                    <div id="collapse{{ $loop->iteration }}" class="collapse" aria-labelledby="heading{{ $loop->iteration }}" data-parent="#accordionExample">
                        <div class="card-body">
                            @if ($user->journal_count > 0)
                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                        <th scope="col">Reference ID</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Category</th>
                                            <th scope="col">Journal</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->journal as $journal_detail)
                                                <tr>
                                                    <td>{{ $journal_detail->reference_id }}</td>
                                                    <td>
                                                        @switch($journal_detail->status )
                                                            @case("Waiting")
                                                                <span class="badge badge-warning text-white">
                                                                    {{ $journal_detail->status }}
                                                                </span>
                                                                @break
                                                            @case("Rejected")
                                                                <span class="badge badge-danger text-white">
                                                                    {{ $journal_detail->status }}
                                                                </span>
                                                                @break
                                                            @case("Approved")
                                                                <span class="badge badge-success text-white">
                                                                    {{ $journal_detail->status }}
                                                                </span>
                                                                @break
                                                            @default
                                                                <span class="badge badge-warning text-white">
                                                                    {{ $journal_detail->status }}
                                                                </span>
                                                        @endswitch
                                                    </td>
                                                <td>{{ $journal_detail->categories ? implode(', ',$journal_detail->categories->pluck('name')->toArray()) :"No Categories" }}</td>
                                                <td>
                                                    <div>
                                                        @if(!empty($journal_detail->getMedia()))
                                                            @foreach ($journal_detail->getMedia() as $item)
                                                                <a href="{{ $item->getUrl() }}" target="_blank" class="btn btn-info">{{ $item->name }}</a>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            @else
                                <strong>
                                    No Journals submitted yet
                                </strong>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-dark" role="alert">
                No user added
                </div>
            @endforelse
        </div>

{{ $users->links() }}

@endsection

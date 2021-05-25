@extends('layouts.reviewer.app')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-body">
                    <div class="card-header mb-4">
                        <h5>Check Journal</h5>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3 col-form-label">Reference ID</label>
                        <div class="col-md-3">
                            <p class="form-control-static">{{$journal->reference_id}}</p>
                        </div>
                        <label class="col-md-3 col-form-label">
                            <strong>
                                Paper
                            </strong>
                        </label>
                        <div class="col-md-3">
                            @if(!empty($paper))
                                <a href="{{$paper}}" class="btn btn-block btn-light" target="_blank" type="button">
                                    <strong>
                                        View Paper
                                    </strong>
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('reviewer.journal.update', [$journal->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label class="col-md-3 col-form-label">Status</label>
                            <div class="col-md-9 col-form-label">
                                <div class="form-check form-check-inline mr-1">
                                    <input
                                        class="form-check-input status"
                                        id="Approved"
                                        type="radio"
                                        value="Approved"
                                        name="status"
                                        {{$journal->status == "Approved" ? "checked" : "" }}>
                                    <label class="form-check-label" for="Approve">Approve</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input status"
                                           id="Waiting"
                                           type="radio"
                                           value="Pending"
                                           name="status"
                                        {{$journal->status == "Waiting" ? "checked" : "" }}>
                                    <label class="form-check-label" for="Waiting">Waiting</label>
                                </div>
                                <div class="form-check form-check-inline mr-1">
                                    <input class="form-check-input status"
                                           id="Reject"
                                           type="radio"
                                           value="Rejected"
                                           name="status"
                                        {{$journal->status == "Rejected" ? "checked" : "" }}>
                                    <label class="form-check-label" for="Reject">Reject</label>
                                </div>
                            </div>
                        </div>
                        @if (in_array($journal->status,["Waiting", 'Rejected'] ))
                            <div class="form-group row reason"  style="display: block" >
                                <label class="col-md-12 col-form-label" for="textarea-input">Reason</label>
                                <div class="col-md-12">
                                    <textarea
                                        class="form-control"
                                        id="textarea-input"
                                        name="reason"
                                        rows="5"
                                        placeholder="Ex: Spelling mistake on page no 2"
                                        ></textarea>
                                </div>
                            </div>
                        @else
                        <div class="form-group row reason"  style="display: none" >
                            <label class="col-md-3 col-form-label" for="textarea-input">Reason</label>
                            <div class="col-md-9">
                                <textarea
                                    class="form-control"
                                    id="textarea-input"
                                    name="reason"
                                    rows="5"
                                    placeholder="Ex: Spelling mistake on page no 2"
                                    ></textarea>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <button class="btn btn-info btn-lg btn-block" type="submit">Submit Journal</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function (event){
            let statusCheckboxes = document.querySelectorAll('.status')
            statusCheckboxes.forEach((checkbox) => {
                checkbox.addEventListener('change' , (e) => {
                    let reasonTextBox = document.querySelector('.reason')
                    $isApproved = checkbox.getAttribute('id');
                    reasonTextBox.style.display = checkbox.checked && $isApproved !== "Approved" ?  "block" : "none";
                    if($isApproved == "Approved" ) {
                        reasonTextBox.value = ""
                    }
                })
            })
        });
    </script>
@endpush


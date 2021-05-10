@extends('layouts.manager.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-header">
                Assign Journal: <strong>{{$journal->reference_id}}</strong>
            </div>
            @if ($reviewers->count() > 0)
                <div class="card-body">
                    <form action="{{ route('manager.assign-journal') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="reviewer">Assign Reviewer</label>
                            <input type="hidden" name="journal_id" value="{{ $journal->id }}">
                            <select class="form-control custom-select custom-select-lg mb-3" id="reviewer" name="reviewer">
                                @foreach($reviewers as $reviewer)
                                    <option value="{{$reviewer->id}}">{{$reviewer->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('reviewers')
                        <small id="passwordHelpBlock" class="text-danger form-text">
                            {{$message}}
                        </small>
                        @enderror
                        <button type="submit" class="btn btn-primary">Assign Reviewer</button>

                    </form>
                </div>
            @else
                No Reviewer found for this category
            @endif

        </div>
    </div>
@endsection



@push('scripts')
    <script>
        $(document).ready(function() {
            $('#reviewer').select2({
                placeholder: "Assign Reviewer",
                allowClear: true,
                cache: true
            });
        });
    </script>
@endpush

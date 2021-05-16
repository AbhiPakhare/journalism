@extends('layouts.user.app')
@push('css')
    <style>
        .card{
            width: 50%;
            margin-left: 25%;

        }
        .razorpay-payment-button {
            color: #fff !important;
            background-color: #2eb85c !important;
            border-color: #2eb85c !important;
            display: block;
            width: 100%;
            font-weight: 400;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            background-color: transparent;
            border: 1px solid transparent;
            padding: .375rem .75rem;
            font-size: .875rem;
            line-height: 1.5;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
        .form-control-plaintext:focus-visible {
            outline: none !important;
        }
    </style>
@endpush
@section('content')

<div class="card">
    <div class="card-header">
        <h4>Payment Gateway</h4>
    </div>
    <div class="card-body">
        @if(!$journal->payment_status)
        <dl class="row">
            <dt class="col-sm-3">Name</dt>
            <dd class="col-sm-9">{{$journal->user->name}} </dd>

            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9"> {{$journal->user->email}} </dd>

            <dt class="col-sm-3">Reference ID</dt>
            <dd class="col-sm-9">{{$journal->reference_id}}</dd>
        </dl>
        <form action="{!!route('user.payment')!!}" method="POST">
            <script src="https://checkout.razorpay.com/v1/checkout.js"
                    data-key="{{ env('RAZOR_KEY') }}"
                    data-amount="60000"
                    data-buttontext="{{__('Pay ₹600')}}"
                    data-name="{{ auth()->user()->name}}"
                    data-description=" {{'Journal Id :'.$journal->reference_id}}"
                    data-prefill.name="{{ auth()->user()->name }}"
                    data-prefill.email="{{ auth()->user()->email }}"
                    data-prefill.contact="{{ auth()->user()->phone->phone_number ?? "" }}"
                    data-theme.color="#3c4b64">
            </script>
            <input type="hidden" name="journal_id" value="{{$journal->id}}">
            <input type="hidden" name="_token" value="{!!csrf_token()!!}">
        </form>
        @else
            <p class="text-danger">
                Payment for {{$journal->reference_id}} has being already done
                <br>
                <i class="fas fa-arrow-left"></i>
                <a href="{{ route('user.journal.index') }}">View all submitted journals</a>
            </p>
        @endif
    </div>
</div>

@endsection
@push('scripts')
    @if(!$errors->any())
       <script>
           $(window).on('load', function() {
               jQuery('.razorpay-payment-button').click();
           });
       </script>
    @endif

@endpush

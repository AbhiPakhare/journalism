@extends('layouts.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="auth-header text-center text-white">
                            <h1>Register</h1>
                        </div>
                        <div class="card-content">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group ">
                                    <label for="name" class="col-form-label text-md-right">{{ __('Name') }}</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                    @error('name')
                                    <small class=" text-danger form-text ">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <small class=" text-danger form-text ">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="phone" class="col-form-label text-md-right">{{ __('Phone Number') }}</label>
                                    <input type="tel" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" maxlength="10" id="phone" type="text" class="form-control" name="phone" autofocus />
                                    @error('phone')
                                    <small class=" text-danger form-text ">
                                        {{ $message }}
                                    </small>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="password" class="col-form-label text-md-right">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                    <small class=" text-danger form-text ">
                                        <strong>{{ $message }}</strong>
                                    </small>
                                    @enderror
                                </div>

                                <div class="form-group ">
                                    <label for="password-confirm" class="col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8">
                                        <button type="submit" class="btn btn-info w-50">
                                            {{ __('Register') }}
                                        </button>
                                        <a class="btn btn-link" href="{{ route('login') }}">
                                            {{ __('Already user? Login here') }}
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

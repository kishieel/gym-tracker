@extends('layouts.default')

@section('content')
    <div class="modal d-block" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered mx-auto" style="width: 360px">
            <div class="modal-content bg-white">
                <div class="d-flex justify-content-center">
                    <div>
                        <img width="150" style="margin-top: -75px"
                             src="{{ secure_asset('static/logo.png') }}"
                             class="shadow-sm rounded-circle"
                             alt="Logo">
                    </div>
                </div>
                <div class="modal-body px-4 py-4">
                    <form class="px-2" method="post" action="{{ route('sign-in.action') }}">
                        @csrf
                        <div class="input-group input-group-lg mb-3 has-validation">
                            <span class="input-group-text bg-light">
                                <i class="fas fa-user"></i>
                            </span>
                            <label for="email" class="sr-only">Email address</label>
                            <input id="email" type="text" name="email" value="{{ old('email') }}"
                                   class="form-control bg-white @error('email') is-invalid @enderror"
                                   placeholder="Email address">
                            @error('email')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="input-group input-group-lg mt-1 mb-3 has-validation">
                            <span class="input-group-text bg-light @error('password') is-invalid @enderror">
                            <i class="fas fa-lock"></i>
                            </span>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" type="password" name="password" value="{{ old('password') }}"
                                   class="form-control bg-white @error('password') is-invalid @enderror"
                                   placeholder="Password">
                            @error('password')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check mb-5">
                            <input id="remember" class="form-check-input" type="checkbox" name="remember" value="true">
                            <label class="form-check-label" for="remember">
                                Remember me
                            </label>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-lg btn-dark w-100">Sign in</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center bg-light px-5 py-3">
                    <a href="#" class="link-secondary btn disabled py-0">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>
@endsection

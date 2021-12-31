@extends('layouts.default')

@section('content')
    <div class="container">
        @include('components.alerts')
        @include('components.navigation', ['breadcrumbs' => [
            route('dashboard.exercises') => 'Dashboard',
            'Profile'
        ]])
        <div class="card text-white bg-dark mb-4 bg-opacity-75">
            <div class="card-body pb-2">
                <h5 class="card-title">Security</h5>
                <h6 class="card-subtitle mb-2 text-muted">Change password</h6>
                @if(session('change-password'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center mt-4" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                        <div>{{ session('change-password') }}</div>
                    </div>
                @endif
                <form method="post" action="{{ route('profile.change-password') }}">
                    @csrf
                    <div class="mt-4 mb-5">
                        <div class="form-floating mb-3">
                            <input id="current_password" type="password" name="current_password"
                                   class="form-control text-light bg-dark @error('current_password') is-invalid @enderror"
                                   placeholder="Current password"/>
                            <label for="quantity">Current password</label>
                            @error('current_password')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input id="new_password" type="password" name="new_password"
                                   class="form-control text-light bg-dark @error('new_password') is-invalid @enderror"
                                   placeholder="New password"/>
                            <label for="quantity">New password</label>
                            @error('new_password')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input id="new_password_confirmation" type="password" name="new_password_confirmation"
                                   class="form-control text-light bg-dark @error('new_password_confirmation') is-invalid @enderror"
                                   placeholder="Confirm password"/>
                            <label for="quantity">Confirm password</label>
                            @error('new_password_confirmation')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-outline-success me-1 mb-2">Change password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

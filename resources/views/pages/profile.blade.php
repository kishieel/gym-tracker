@extends('layouts.default')

@section('content')
    <div class="container">
        <x-navigation>
            <x-navigation.breadcrumb>
                Profile
            </x-navigation.breadcrumb>
        </x-navigation>
        <x-card>
            <x-slot name="title">Security</x-slot>
            <x-slot name="subtitle">Change password</x-slot>
            @if(session('change-password'))
                <x-alert.success dismissible>
                    {{ session('change-password') }}
                </x-alert.success>
            @endif
            <x-form method="post" action="{{ route('profile.change-password') }}">
                <div class="mt-4 mb-5">
                    <x-form.input name="current_password" type="password" label="Current password"/>
                    <x-form.input name="new_password" type="password" label="New password"/>
                    <x-form.input name="new_password_confirmation" type="password" label="Confirm password"/>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-outline-success me-1 mb-2">Change password</button>
                </div>
            </x-form>
        </x-card>
    </div>
@endsection

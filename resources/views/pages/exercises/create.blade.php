@extends('layouts.default')

@section('content')
    <div class="container">
        <x-navigation>
            <x-navigation.breadcrumb url="{{ route('dashboard.exercises') }}">
                Dashboard
            </x-navigation.breadcrumb>
            <x-navigation.breadcrumb>Create new exercise</x-navigation.breadcrumb>
        </x-navigation>
        <x-card>
            <x-slot name="title">Create new exercise</x-slot>
            <x-slot name="subtitle">Dashboard</x-slot>
            <x-form method="post" action="{{ route('exercises.store') }}">
                <div class="mt-4 mb-5">
                    <x-form.input name="label" value="{{ old('label') }}" label="Label"/>
                    <x-form.select name="type" label="Ranking type">
                        <option selected disabled>Select exercise ranking type</option>
                        @foreach(\App\Enums\ExerciseType::getInstances() as $key => $value)
                            <option value="{{ $value }}">{{ $key }}</option>
                        @endforeach
                    </x-form.select>
                    <x-form.select name="unit" label="Workout unit">
                        <option selected disabled>Select exercise workout unit</option>
                        @foreach(\App\Enums\RepetitionUnit::getInstances() as $key => $value)
                            <option value="{{ $value }}">{{ $key }} ({{ $value }})</option>
                        @endforeach
                    </x-form.select>
                </div>
                <div class="text-end">
                    <div class="text-end">
                        <a href="{{ route('dashboard.exercises') }}"
                           class="btn btn-outline-danger me-1 mb-2">Cancel</a>
                        <button type="submit" class="btn btn-outline-success me-1 mb-2">Create exercise</button>
                    </div>
                </div>
            </x-form>
        </x-card>
    </div>
@endsection

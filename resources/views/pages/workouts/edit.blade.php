@extends('layouts.default')

@section('content')
    <div class="container">
        <x-navigation>
            <x-navigation.breadcrumb url="{{ route('dashboard.exercises') }}">
                Dashboard
            </x-navigation.breadcrumb>
            <x-navigation.breadcrumb url="{{ route('exercises.show', ['exercise' => $exercise]) }}">
                {{ $exercise->label }}
            </x-navigation.breadcrumb>
            <x-navigation.breadcrumb>Update your workout</x-navigation.breadcrumb>
        </x-navigation>
        <x-card>
            <x-slot name="title">{{ $exercise->label }}</x-slot>
            <x-slot name="subtitle">{{ ucfirst($exercise->type) }}</x-slot>
            <x-form method="put" action="{{ route('workouts.update', ['exercise' => $exercise, 'workout' => $workout]) }}">
                <div class="mt-4 mb-5">
                    <x-form.input name="quantity" value="{{ old('quantity', $workout->quantity) }}" label="Quantity ({{ $exercise->unit }})"/>
                    <x-form.input name="workout_at" value="{{ old('workout_at', $workout->workout_at) }}" label="Workout at"/>
                </div>
                <div class="text-end">
                    <a href="{{route('exercises.show', ['exercise' => $exercise])}}"
                       class="btn btn-outline-danger me-1 mb-2">Cancel</a>
                    <button type="submit" class="btn btn-outline-success me-1 mb-2">Update your workout</button>
                </div>
            </x-form>
        </x-card>
    </div>
@endsection


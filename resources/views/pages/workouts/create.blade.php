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
            <x-navigation.breadcrumb>Add your workout</x-navigation.breadcrumb>
        </x-navigation>
        <x-card>
            <x-slot name="title">{{ $exercise->label }}</x-slot>
            <x-slot name="subtitle">{{ ucfirst($exercise->type) }}</x-slot>
            <x-form method="post" action="{{ route('workouts.store', ['exercise' => $exercise]) }}">
                <div class="mt-4 mb-5">
                    <input type="hidden" name="exercise_id" value="{{ $exercise->id }}"/>
                    <x-form.input name="quantity" value="{{ old('quantity') }}" label="Quantity ({{ $exercise->unit }})"/>
                    <x-form.input name="workout_at" value="{{ old('workout_at', now()->timezone('Europe/Warsaw')->format('d M Y H:i')) }}" label="Workout at"/>
                </div>
                <div class="text-end">
                    <a href="{{ route('exercises.show', ['exercise' => $exercise]) }}"
                       class="btn btn-outline-danger me-1 mb-2">Cancel</a>
                    <button type="submit" class="btn btn-outline-success me-1 mb-2">Add your workout</button>
                </div>
            </x-form>
        </x-card>
    </div>
@endsection


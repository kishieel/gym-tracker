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
        <div class="card text-white bg-dark mb-4 bg-opacity-75">
            <div class="card-body pb-2">
                <h5 class="card-title">{{ $exercise->label }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst($exercise->type) }}</h6>
                <form method="post" action="{{ route('workouts.store', ['exercise' => $exercise->id]) }}">
                    @csrf
                    <input type="hidden" name="exercise_id" value="{{ $exercise->id }}"/>
                    <div class="mt-4 mb-5">
                        <div class="form-floating mb-3">
                            <input id="quantity" type="text" name="quantity" value="{{ old('quantity') }}" class="form-control text-light bg-dark @error('quantity') is-invalid @enderror"
                                   placeholder="Quantity ({{ $exercise->unit }})"/>
                            <label for="quantity">Quantity ({{ $exercise->unit }})</label>
                            @error('quantity')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3">
                            <input id="workout_at" type="text" name="workout_at" value="{{ old('workout_at') ?? now()->timezone('Europe/Warsaw')->format('d M Y H:i') }}" class="form-control text-light bg-dark @error('workout_at') is-invalid @enderror"
                                   placeholder="Workout at"/>
                            <label for="workout_at">Workout at</label>
                            @error('workout_at')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('exercises.show', ['exercise' => $exercise]) }}" class="btn btn-outline-danger me-1 mb-2">Cancel</a>
                        <button type="submit" class="btn btn-outline-success me-1 mb-2">Add your workout</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


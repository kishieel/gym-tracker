@extends('layouts.default')

@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.26.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>
@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/css/bootstrap-datepicker.css"
          rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        @include('components.navigation', ['breadcrumbs' => [
            route('dashboard.exercises') => 'Dashboard',
            $exercise->label,
            'Add your entry'
        ]])
        <div class="card text-white bg-dark mb-4 bg-opacity-75">
            <div class="card-body pb-2">
                <h5 class="card-title">{{ $exercise->label }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst($exercise->type) }}</h6>
                <form method="post" action="{{ route('repetitions.store', ['exercise' => $exercise->id]) }}">
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
                            <input id="workout_at" type="text" name="workout_at" value="{{ old('workout_at') ?? now()->timezone('Europe/Warsaw')->format('Y-m-d H:i') }}" class="form-control text-light bg-dark @error('workout_at') is-invalid @enderror"
                                   placeholder="Workout at"/>
                            <label for="workout_at">Workout at</label>
                            @error('workout_at')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{route('dashboard.exercises')}}" class="btn btn-outline-danger me-1 mb-2">Cancel</a>
                        <button type="submit" class="btn btn-outline-success me-1 mb-2">Add your entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


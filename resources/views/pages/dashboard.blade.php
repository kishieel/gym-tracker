@extends('layouts.default')

@section('content')
    <div class="container">
        @include('components.navigation', ['breadcrumbs' => ['Dashboard']])
        @foreach ($exercises as $exercise)
            <div class="card text-white bg-dark mb-4 bg-opacity-75">
                <div class="card-body pb-2">
                    <h5 class="card-title">{{ $exercise->label }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ ucfirst($exercise->type) }}</h6>
                    <div class="table-responsive-md mt-4 mb-5">
                        <table class="table table-dark table-hover m-0">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First name</th>
                                <th scope="col">Last name</th>
                                <th scope="col">
                                    @if($exercise->type === \App\Enums\ExerciseType::Incremental)
                                        Summary
                                    @else
                                        Record
                                    @endif
                                </th>
                                <th scope="col">Updated at</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($exercise->participants as $index => $participant)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $participant->first_name }}</td>
                                    <td>{{ $participant->last_name }}</td>
                                    <td>
                                        @if($exercise->type === \App\Enums\ExerciseType::Incremental)
                                            {{ $participant->summary }} {{ $exercise->unit  }}
                                        @else
                                            {{ $participant->record }} {{ $exercise->unit  }}
                                        @endif
                                    </td>
                                    <td>{{ $participant->last_workout_at->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <a href="#" class="btn btn-outline-danger me-1 mb-2">Remove category</a>
                        <a href="#" class="btn btn-outline-info me-1 mb-2">Show details</a>
                        <a href="#" class="btn btn-outline-warning me-1 mb-2">Update category</a>
                        <a href="{{ route('repetitions.create', ['exercise' => $exercise->id]) }}"
                           class="btn btn-outline-success me-1 mb-2">Add your entry</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

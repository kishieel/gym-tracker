@extends('layouts.default')

@section('content')
    <div class="container">
        <x-navigation>
            <x-navigation.breadcrumb>
                Dashboard
            </x-navigation.breadcrumb>
        </x-navigation>
        <nav class="navbar navbar-expand-md  navbar-dark bg-dark mb-4 bg-opacity-75 rounded py-3">
            <div class="container-fluid">
                <div class="navbar-nav">
                    <x-form class="nav-link py-0">
                        <input type="hidden" name="my-exercises"
                               value="{{ ! request()->boolean('my-exercises') }}"/>
                        <button type="submit" class="btn btn-outline-light">
                            @if(request()->boolean('my-exercises'))
                                All exercises
                            @else
                                Only my exercises
                            @endif
                        </button>
                    </x-form>
                    <div class="nav-link py-0">
                        <div class="btn btn-outline-light">Create new exercise</div>
                    </div>
                </div>
                <x-form class="d-flex">
                    <input class="form-control me-2" type="search" name="filter" placeholder="Search exercise"
                           value="{{ request()->get('filter')  }}" aria-label="Search">
                    <button class="btn btn-outline-light" type="submit">Search</button>
                </x-form>
            </div>
        </nav>
        @foreach ($exercises as $exercise)
            <x-card :disabled="$exercise->trashed()">
                <x-slot name="title">{{ $exercise->label }}</x-slot>
                <x-slot name="subtitle">{{ ucfirst($exercise->type) }}</x-slot>
                <div class="table-responsive-md mt-4 mb-5">
                    <table
                        class="table table-dark table-hover m-0 @if($exercise->trashed()) text-secondary @else text-light @endif">
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
                                <td>{{ $participant->last_workout_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="text-end">
                    @can('delete', $exercise)
                        <x-form class="d-inline" method="delete"
                                action="{{ route('exercises.destroy', ['exercise' => $exercise]) }}">
                            <button type="submit" class="btn btn-outline-danger me-1 mb-2">Remove exercise</button>
                        </x-form>
                    @endcan
                    @can('update', $exercise)
                        <a href="{{ route('exercises.edit', ['exercise' => $exercise->id]) }}"
                           class="btn btn-outline-warning me-1 mb-2">Update exercise</a>
                    @endcan
                    @can('restore',$exercise)
                        <x-form class="d-inline" method="patch"
                                action="{{ route('exercises.restore', ['exercise' => $exercise]) }}">
                            <button type="submit" class="btn btn-outline-info me-1 mb-2">Restore exercise</button>
                        </x-form>
                    @endcan
                    @if(! $exercise->trashed())
                        <a href="{{ route('exercises.show', ['exercise' => $exercise->id]) }}"
                           class="btn btn-outline-info me-1 mb-2">Show details</a>
                        <a href="{{ route('workouts.create', ['exercise' => $exercise->id]) }}"
                           class="btn btn-outline-success me-1 mb-2">Add your workout</a>
                    @endif
                </div>
            </x-card>
        @endforeach
    </div>
@endsection

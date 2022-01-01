@extends('layouts.default')

@section('content')
    <div class="container">
        <x-navigation>
            <x-navigation.breadcrumb url="{{ route('dashboard.exercises') }}">
                Dashboard
            </x-navigation.breadcrumb>
            <x-navigation.breadcrumb>
                {{ $exercise->label }}
            </x-navigation.breadcrumb>
        </x-navigation>
        <x-card :disabled="$exercise->trashed()">
            @aware(['disabled' => false])
            <x-slot name="title">{{ $exercise->label }}</x-slot>
            <x-slot name="subtitle">Leaderboard</x-slot>
            <div class="my-4">
                @foreach($leaders as $leader)
                    {{ $leader->first_name }} {{ $leader->last_name }}
                    - {{ $leader->summary }} {{ $exercise->unit }}
                    <div class="progress mb-3">
                        <div
                            class="progress-bar progress-bar-striped progress-bar-animated @if($disabled) bg-secondary @endif"
                            role="progressbar"
                            aria-valuenow="{{ $leader->summary / $leaders[0]->summary * 100 }}" aria-valuemin="0"
                            aria-valuemax="100"
                            style="width: {{ $leader->summary / $leaders[0]->summary * 100 }}%">
                            <strong>{{ $leader->summary }} {{ $exercise->unit }}</strong>
                        </div>
                    </div>
                @endforeach
            </div>
        </x-card>
        <x-card id="history" :disabled="$exercise->trashed()">
            @aware(['disabled' => false])
            <x-slot name="title">{{ $exercise->label }}</x-slot>
            <x-slot name="subtitle">History</x-slot>
            @if(session('status'))
                <x-alert.success dismissible>{{ session('status') }}</x-alert.success>
            @endif
            <div class="table-responsive-md my-4">
                <table class="table table-dark table-hover m-0 @if($disabled) text-secondary @endif">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First name</th>
                        <th scope="col">Last name</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Workout at</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($workouts as $index => $workout)
                        <tr>
                            <th scope="row">{{ $index + 1 }}</th>
                            <td class="text-nowrap">{{ $workout->first_name }}</td>
                            <td class="text-nowrap">{{ $workout->last_name }}</td>
                            <td class="text-nowrap">{{ $workout->quantity }} {{ $exercise->unit  }}</td>
                            <td class="text-nowrap">{{ $workout->workout_at->format('d M Y H:i') }}</td>
                            <td class="text-end text-nowrap py-1">
                                @can('delete', $workout)
                                    <x-form class="d-inline-block" method="delete"
                                            action="{{ route('workouts.destroy', ['exercise' => $exercise->id, 'workout' => $workout->id]) }}">
                                        <button type='submit' class="btn btn-sm btn-outline-danger me-1"
                                                @if($disabled) disabled @endif>
                                            Delete
                                        </button>
                                    </x-form>
                                @endcan
                                @can('update', $workout)
                                    <a href="{{ route('workouts.edit', ['exercise' => $exercise->id, 'workout' => $workout->id]) }}"
                                       class="btn btn-sm btn-outline-warning me-1 @if($disabled) disabled @endif">
                                        Update
                                    </a>
                                @endcan
                                @can('restore', $workout)
                                    <x-form class="d-inline-block" method="patch"
                                            action="{{ route('workouts.restore', ['exercise' => $exercise->id, 'workout' => $workout->id]) }}">
                                        <button type='submit' class="btn btn-sm btn-outline-info me-1"
                                                @if($disabled) disabled @endif>
                                            Restore
                                        </button>
                                    </x-form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-between">
                {{ $workouts->onEachSide(5)->links() }}
                <div class="text-end ms-auto">
                    @can('delete', $exercise)
                        <form class="d-inline"
                              action="{{ route('exercises.destroy', ['exercise' => $exercise]) }}"
                              method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-outline-danger me-1 mb-2">
                                Remove exercise
                            </button>
                        </form>
                    @endcan
                    @can('update', $exercise)
                        <a href="{{ route('exercises.edit', ['exercise' => $exercise]) }}"
                           class="btn btn-outline-warning me-1 mb-2">Update exercise</a>
                    @endcan
                    @can('restore',$exercise)
                        <form class="d-inline-block" method="post"
                              action="{{ route('exercises.restore', ['exercise' => $exercise]) }}">
                            @method('patch')
                            @csrf
                            <button type='submit' class="btn btn-outline-info mb-2 me-1">
                                Restore exercise
                            </button>
                        </form>
                    @endcan
                    @if(! $exercise->trashed())
                        <a href="{{ route('workouts.create', ['exercise' => $exercise]) }}"
                           class="btn btn-outline-success me-1 mb-2">Add your workout</a>
                    @endif
                </div>
            </div>
        </x-card>
    </div>
@endsection


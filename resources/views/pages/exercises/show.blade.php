@extends('layouts.default')

@section('content')
    <div class="container">
        @include('components.navigation', ['breadcrumbs' => [
            route('dashboard.exercises') => 'Dashboard',
            $exercise->label,
        ]])
        <div class="card text-white bg-dark mb-4 bg-opacity-75">
            <div class="card-body pb-2">
                <h5 class="card-title">{{ $exercise->label }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">Leaderboard</h6>
                <div class="my-4">
                    @foreach($leaders as $leader)
                        {{ $leader->first_name }} {{ $leader->last_name }}
                        - {{ $leader->summary }} {{ $exercise->unit }}
                        <div class="progress mb-3">
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                                 aria-valuenow="{{ $leader->summary / $leaders[0]->summary * 100 }}" aria-valuemin="0"
                                 aria-valuemax="100"
                                 style="width: {{ $leader->summary / $leaders[0]->summary * 100 }}%">
                                <strong>{{ $leader->summary }} {{ $exercise->unit }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div id='history' class="card text-white bg-dark mb-4 bg-opacity-75">
            <div class="card-body pb-2">
                <h5 class="card-title">{{ $exercise->label }}</h5>
                <h6 class="card-subtitle mb-2 text-muted">History</h6>
                <div class="table-responsive-md my-4">
                    <table class="table table-dark table-hover m-0">
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
                        @foreach($repetitions as $index => $repetition)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td class="text-nowrap">{{ $repetition->first_name }}</td>
                                <td class="text-nowrap">{{ $repetition->last_name }}</td>
                                <td class="text-nowrap">{{ $repetition->quantity }} {{ $exercise->unit  }}</td>
                                <td class="text-nowrap">{{ $repetition->workout_at->format('d M Y H:i') }}</td>
                                <td class="text-end text-nowrap py-1">
                                    @if(!$repetition->deleted_at)
                                        @can('delete', $repetition)
                                            <form class="d-inline-block" method="post"
                                                  action="{{ route('repetitions.destroy', ['exercise' => $exercise->id, 'repetition' => $repetition->id]) }}">
                                                @method('delete')
                                                @csrf
                                                <button type='submit' class="btn btn-sm btn-outline-danger me-1">
                                                    Delete
                                                </button>
                                            </form>
                                        @endcan
                                    @else
                                        @can('restore', $repetition)
                                            <form class="d-inline-block" method="post"
                                                  action="{{ route('repetitions.restore', ['exercise' => $exercise->id, 'repetition' => $repetition->id]) }}">
                                                @method('patch')
                                                @csrf
                                                <button type='submit' class="btn btn-sm btn-outline-info me-1">
                                                    Restore
                                                </button>
                                            </form>
                                        @endcan
                                    @endif
                                    @can('update', $repetition)
                                        @if(!$repetition->deleted_at)
                                            <a href="{{ route('repetitions.edit', ['exercise' => $exercise->id, 'repetition' => $repetition->id]) }}"
                                               class="btn btn-sm btn-outline-warning me-1">
                                                Update
                                            </a>
                                        @endif
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-between">
                    {{ $repetitions->onEachSide(5)->links() }}
                    <div class="text-end ms-auto">
                        <a href="{{ route('repetitions.create', ['exercise' => $exercise->id]) }}"
                           class="btn btn-outline-success me-1 mb-2">Add your entry</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


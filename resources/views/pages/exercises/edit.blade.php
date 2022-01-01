@extends('layouts.default')

@section('content')
    <div class="container">
        <x-navigation>
            <x-navigation.breadcrumb url="{{ route('dashboard.exercises') }}">
                Dashboard
            </x-navigation.breadcrumb>
            <x-navigation.breadcrumb url="{{ route('exercises.show', ['exercise' => $exercise]) }}">
                {{ $exercise->label  }}
            </x-navigation.breadcrumb>
            <x-navigation.breadcrumb>Update exercises</x-navigation.breadcrumb>
        </x-navigation>
        <x-card>
            <x-slot name="title">{{ $exercise->label }}</x-slot>
            <x-slot name="subtitle">Update</x-slot>
            @if(session('status'))
                <x-alert.success dismissible="true">
                    {{  session('status') }}
                </x-alert.success>
            @endif
            <x-form method="put"
                         action="{{ route('exercises.update', ['exercise' => $exercise]) }}">
                <div class="mt-4 mb-5">
                    <x-form.input name="label" value="{{ old('label', $exercise->label) }}" label="Label"/>
                    <x-form.select name="type" label="Ranking type">
                        <option disabled>Select exercise ranking type</option>
                        @foreach(\App\Enums\ExerciseType::getInstances() as $key => $value)
                            <option value="{{ $value }}" @if($value == old('type', $exercise->type)) selected @endif>
                                {{ $key }}
                            </option>
                        @endforeach
                    </x-form.select>
                    <x-form.select name="unit" label="Workout unit">
                        <option disabled>Select exercise workout unit</option>
                        @foreach(\App\Enums\RepetitionUnit::getInstances() as $key => $value)
                            <option value="{{ $value }}" @if($value == old('unit', $exercise->unit)) selected @endif>
                                {{ $key }} ({{ $value }})
                            </option>
                        @endforeach
                    </x-form.select>
                </div>
                <div class="text-end">
                    <a href="{{ route('exercises.show', ['exercise' => $exercise]) }}"
                       class="btn btn-outline-danger me-1 mb-2">Cancel</a>
                    <button type="submit" class="btn btn-outline-success me-1 mb-2">Update exercise</button>
                </div>
            </x-form>
        </x-card>
    </div>
@endsection


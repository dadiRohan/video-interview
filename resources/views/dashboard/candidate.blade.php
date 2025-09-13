@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Candidate Dashboard</h2>

    <h4>Available Interviews</h4>
    @forelse($interviews as $iv)
        <div class="card mb-2">
            <div class="card-body">
                <h5>{{ $iv->title }}</h5>
                <p>{{ $iv->description }}</p>
                <a href="{{ route('interviews.show', $iv) }}" class="btn btn-sm btn-primary">Start Interview</a>
            </div>
        </div>
    @empty
        <p>No interviews available right now.</p>
    @endforelse
</div>
@endsection

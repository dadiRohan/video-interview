@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Admin / Reviewer Dashboard</h2>

    <a href="{{ route('interviews.create') }}" class="btn btn-primary mb-3">+ Create Interview</a>

    <h4>All Interviews</h4>
    @forelse($interviews as $iv)
        <div class="card mb-2">
            <div class="card-body">
                <h5>{{ $iv->title }}</h5>
                <p>{{ $iv->description }}</p>
                <a href="{{ route('interviews.show', $iv) }}" class="btn btn-sm btn-outline-secondary">View</a>
            </div>
        </div>
    @empty
        <p>No interviews created yet.</p>
    @endforelse

    <hr>
    <a href="{{ route('reviewer.submissions') }}" class="btn btn-success">Review Submissions</a>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="container">
  <h2>Interviews</h2>
  @if(Auth::user()->role != 'candidate')
    <a href="{{ route('interviews.create') }}" class="btn btn-primary mb-3">Create Interview</a>
  @endif
  @foreach($interviews as $iv)
    <div class="card mb-2">
      <div class="card-body">
        <h5>{{ $iv->title }}</h5>
        <p>{{ $iv->description }}</p>
        <a href="{{ route('interviews.show',$iv) }}" class="btn btn-sm btn-outline-secondary">Open</a>
      </div>
    </div>
  @endforeach
</div>
@endsection

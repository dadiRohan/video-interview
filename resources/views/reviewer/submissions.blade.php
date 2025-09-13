@extends('layouts.app')
@section('content')
<div class="container">
  <h3>Submissions</h3>
  @foreach($submissions as $s)
    <div class="card mb-3 p-3">
      <p><strong>Interview:</strong> {{ $s->interview->title }} - <strong>Question:</strong> {{ $s->question->text }}</p>
      <p><strong>Candidate:</strong> {{ $s->candidate->name }} ({{ $s->candidate->email }})</p>
      <video style="width:480px;height:360px" controls>
        <source src="{{ asset('storage/'.$s->video_path) }}">
        Your browser doesn't support video tag.
      </video>
      <form action="{{ route('reviewer.submissions.review', $s) }}" method="post" class="mt-2">
        @csrf
        <div class="form-group">
          <label>Score (0-100)</label>
          <input name="score" type="number" min="0" max="100" value="{{ $s->score }}" class="form-control" style="width:120px">
        </div>
        <div class="form-group">
          <label>Comment</label>
          <textarea name="comment" class="form-control">{{ $s->comment }}</textarea>
        </div>
        <button class="btn btn-primary">Save</button>
      </form>
    </div>
  @endforeach
</div>
@endsection

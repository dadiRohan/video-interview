@extends('layouts.app')
@section('content')
<div class="container">
  <h2>Create Interview</h2>
  <form action="{{ route('interviews.store') }}" method="post">
    @csrf
    <div class="form-group">
      <label>Title</label>
      <input name="title" class="form-control" required>
    </div>
    <div class="form-group">
      <label>Description</label>
      <textarea name="description" class="form-control"></textarea>
    </div>
    <div id="questions">
      <label>Questions</label>
      <div class="form-group">
        <input name="questions[]" class="form-control mb-2" placeholder="Question 1" required>
      </div>
    </div>
    <button type="button" class="btn btn-link" onclick="addQuestion()">+ Add question</button>
    <br>
    <button class="btn btn-primary mt-2">Create</button>
  </form>
</div>

<script>
function addQuestion(){
  const div = document.createElement('div');
  div.className = 'form-group';
  div.innerHTML = '<input name="questions[]" class="form-control mb-2" placeholder="Question" required>';
  document.getElementById('questions').appendChild(div);
}
</script>
@endsection

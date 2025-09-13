@extends('layouts.app')
@section('content')
<div class="container">
  <h3>{{ $interview->title }}</h3>
  <p>{{ $interview->description }}</p>

  @foreach($interview->questions as $q)
    <div class="card mb-3 p-2">
      <h5>Q{{ $loop->iteration }}: {{ $q->text }}</h5>

      <div id="recorder-{{ $q->id }}">
        <video id="preview-{{ $q->id }}" playsinline autoplay muted style="width:320px;height:240px;background:#000"></video>
        <br>
        <button class="btn btn-sm btn-success" onclick="startRecording({{ $q->id }})">Start</button>
        <button class="btn btn-sm btn-warning" onclick="stopRecording({{ $q->id }})">Stop</button>

        <form id="uploadForm-{{ $q->id }}" action="{{ route('submissions.store') }}" method="post" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="interview_id" value="{{ $interview->id }}">
          <input type="hidden" name="question_id" value="{{ $q->id }}">
          <input type="file" name="video" id="file-{{ $q->id }}" accept="video/*" style="display:none;">
          <button type="button" class="btn btn-primary mt-2" onclick="uploadRecorded({{ $q->id }})">Upload Answer</button>
        </form>
      </div>

      <div class="mt-2">
        <!-- show last submission by this candidate for this question -->
        @php
           $sub = \App\Models\Submission::where('question_id',$q->id)->where('candidate_id',Auth::id())->latest()->first();
        @endphp
        @if($sub)
          <p>Last submission: <a target="_blank" href="{{ asset('storage/'.$sub->video_path) }}">View Video</a> — Score: {{ $sub->score ?? 'N/A' }}</p>
        @endif
      </div>
    </div>
  @endforeach

</div>

<script>
const recorders = {}; // { questionId: { mediaRecorder, chunks: [] } }
async function startRecording(qid){
  const preview = document.getElementById('preview-'+qid);
  if(!navigator.mediaDevices) return alert('No camera support');
  const stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: true });
  preview.srcObject = stream;

  const options = { mimeType: 'video/webm;codecs=vp8,opus' };
  const mediaRecorder = new MediaRecorder(stream, options);
  recorders[qid] = { mediaRecorder, chunks: [], stream };

  mediaRecorder.ondataavailable = e => { if(e.data.size>0) recorders[qid].chunks.push(e.data); };
  mediaRecorder.start();
}

function stopRecording(qid){
  const r = recorders[qid];
  if(!r) return;
  r.mediaRecorder.stop();
  r.stream.getTracks().forEach(t=>t.stop());
  r.mediaRecorder.onstop = () => {
    const blob = new Blob(r.chunks, { type: 'video/webm' });
    // create file input
    const fileInput = document.getElementById('file-'+qid);
    const file = new File([blob], `answer_q${qid}.webm`, { type: 'video/webm' });

    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    fileInput.files = dataTransfer.files;

    // preview playback
    const preview = document.getElementById('preview-'+qid);
    preview.srcObject = null;
    preview.src = URL.createObjectURL(blob);
    preview.muted = false;
    preview.play();
    // stash blob so upload uses it if necessary
    recorders[qid].blob = blob;
  };
}

function uploadRecorded(qid){
  const fileInput = document.getElementById('file-'+qid);
  if(!fileInput.files.length) return alert('Record something first');
  const form = document.getElementById('uploadForm-'+qid);
  const fd = new FormData(form);
  fd.append('video', fileInput.files[0]);
  fetch(form.action, {
    method: 'POST',
    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
    body: fd
  }).then(r => r.text()).then(() => { alert('Uploaded'); location.reload(); })
  .catch(e => { console.error(e); alert('Upload failed'); });
}
</script>
@endsection

<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model {
    protected $fillable = ['interview_id','question_id','candidate_id','video_path','score','comment'];

    public function question(){ return $this->belongsTo(Question::class); }
    public function candidate(){ return $this->belongsTo(\App\Models\User::class,'candidate_id'); }
    public function interview(){ return $this->belongsTo(Interview::class); }
}

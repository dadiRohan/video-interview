<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Question extends Model {
    protected $fillable = ['interview_id','text','order'];

    public function interview() {
        return $this->belongsTo(Interview::class);
    }
}

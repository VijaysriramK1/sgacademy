<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantAnswer extends Model
{
    protected $table = 'participant_answers';

    protected $fillable = [
        'exam_participant_id',
        'question_id',
        'answer',
        'mark',
        'error_mark',
    ];

    public function examParticipant()
    {
        return $this->belongsTo(OnlineExamParticipant::class,'exam_participant_id');
    }

   
    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
}

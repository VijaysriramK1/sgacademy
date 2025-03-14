<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    protected $table = 'question_options';

    protected $fillable = [
        'name',
        'is_answer',
        'status',
        'question_id',
    ];

    /**
     * Define the relationship to the Question model.
     */
    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
}

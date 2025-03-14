<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineExam extends Model
{
    protected $table = 'online_exams';
    protected $fillable = [
        'title',
        'date',
        'start_time',
        'end_time',
        'end_date_time',
        'percentage',
        'instruction',
        'is_published',
        'is_taken',
        'is_closed',
        'is_waiting',
        'is_running',
        'auto_mark',
        'status',
        'created_by',
        'updated_by',
        'institution_id',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}

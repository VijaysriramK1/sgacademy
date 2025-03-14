<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSetup extends Model
{
    // Table name (optional if following naming convention)
    protected $table = 'exam_setups';

    // Fillable fields
    protected $fillable = [
        'exam_id',
        'name',
        'min_mark',
        'mark',
        'status',
    ];

    /**
     * Relationship with Exam model
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}

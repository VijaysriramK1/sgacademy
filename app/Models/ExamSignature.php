<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSignature extends Model
{
    
    protected $table = 'exam_signatures';

   
    protected $fillable = [
        'title',
        'signature',
        'status',
        'batch_id',
        'institution_id',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}

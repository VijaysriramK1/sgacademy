<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnlineExamProgram extends Model
{
    protected $table = 'online_exam_programs';

    protected $fillable = ['batch_id','program_id','semester_id','section_id','status'];

    public function program()
    {
        return $this->belongsTo(Program::class,'program_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

}

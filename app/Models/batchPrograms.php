<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BatchPrograms extends Model
{
    protected $table = 'batch_programs';
    protected $fillable = ['batch_id', 'program_id', 'section_id', 'semester_id', 'status', 'institution_id', 'batch_group'];


    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}

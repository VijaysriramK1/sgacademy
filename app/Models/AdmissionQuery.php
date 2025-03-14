<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class AdmissionQuery extends Model
{
 
    protected $table = 'admissions';

  
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'description',
        'date',
        'follow_up_date',
        'next_follow_up_date',
        'assigned',
        'reference',
        'no_of_child',
        'status',
        'student_status',
        'source_type_id',
        'program_id',
        'batch_id',
        'created_by',
        'updated_by',
        'institution_id',
    ];
    
    public function program()
    {
        return $this->belongsTo(Program::class,'program_id');
    }

    public function Source()
    {
        return $this->belongsTo(SourceType::class,'source_type_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class,'batch_id');
    }

}

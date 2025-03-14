<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    protected $table = 'batches';
    protected $fillable = ['name', 'year', 'start_date', 'end_date', 'copy_with_academic_year', 'status', 'institution_id'];


    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}

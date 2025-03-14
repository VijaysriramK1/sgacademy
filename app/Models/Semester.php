<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semesters';
    protected $fillable = [
        'name',
        'year',
        'institution_id',
    ];
    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}

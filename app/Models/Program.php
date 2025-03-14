<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    protected $fillable = [
        'name',
        'program_code',
        'institution_id',
    ];
    protected $table = 'programs';

    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function admissionfees()
    {
        return $this->hasMany(AdmissionFees::class);
    }
}

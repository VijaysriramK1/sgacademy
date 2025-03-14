<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeSetup extends Model
{
    protected $table = 'grade_setups';

    protected $fillable = [
		'grade_id','name','gpa','min_mark','max_mark','min_percent','max_percent','status','description'
	];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

}

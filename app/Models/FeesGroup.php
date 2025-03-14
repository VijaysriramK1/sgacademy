<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesGroup extends Model
{
    protected $table = 'fee_groups';

    protected $fillable = [
		'name','description','status','institution_id'
	];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesType extends Model
{
    protected $table = 'fee_types';

    protected $fillable = [
		'name','description','status','institution_id','fee_group_id','type'
	];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function feesgroup()
    {
        return $this->belongsTo(FeesGroup::class, 'fee_group_id');
    }
}

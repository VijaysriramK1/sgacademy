<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionFees extends Model
{
    protected $table = 'admission_fees';

    protected $fillable = [
		'fee_type_id','program_id','batch_id','amount','institution_id'
	];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function feestype()
    {
        return $this->belongsTo(FeesType::class, 'fee_type_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
}

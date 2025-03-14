<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $table = 'scholarships';
    protected $fillable = ['name', 'description', 'eligibility_criteria', 'coverage_amount', 'coverage_type', 'applicable_fee_ids', 'batch_id', 'institution_id'];
}

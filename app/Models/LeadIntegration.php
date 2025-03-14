<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadIntegration extends Model
{
    protected $table = 'setup_admins';

  
    protected $fillable = ['type', 'name', 'description', 'active_status'];
}

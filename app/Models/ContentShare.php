<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentShare extends Model
{
    protected $table = 'content_share_lists';
    
    protected $fillable = [
        'title',
        'share_date',
        'valid_upto',
        'description',
        'send_type',
        'content_ids',
        'gr_role_ids',
        'ind_user_ids',
        'program_id',
        'section_ids',
        'url',
        'shared_by',
        'institution_id'
    ];

    protected $casts = [
        'share_date' => 'date',
        'valid_upto' => 'date',
        'content_ids' => 'json',
        'gr_role_ids' => 'json',
        'ind_user_ids' => 'json',
        'section_ids' => 'json',
        'url' => 'json'
    ];

    public function User(){
        return $this->belongsTo(User::class, 'shared_by');
    }

    public function institution(){
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
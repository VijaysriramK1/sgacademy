<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    protected $fillable = ['content_title','content_type','available_for_admin','available_for_all_programs','upload_date','description','source_url','upload_file','status','program_id','section_id'];
   
    public function program()
    {
        return $this->belongsTo(Program::class,'program_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }

}

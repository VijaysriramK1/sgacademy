<?php

namespace App\Models;

use App\Models\StudentScholarship;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;
    protected $table = 'students';
    protected $fillable = ['first_name', 'last_name', 'email', 'mobile', 'admission_no', 'roll_no', 'dob', 'gender', 'blood_group', 'height', 'weight', 'admission_date', 'student_photo', 'current_address', 'permanent_address', 'national_id_no', 'local_id_no', 'bank_account_no', 'bank_name', 'ifsc_code', 'aditional_notes', 'user_id', 'institution_id', 'document_title_1', 'document_file_1', 'document_title_2', 'document_file_2', 'document_title_3', 'document_file_3', 'document_title_4', 'document_file_4', 'status', 'custom_field', 'custom_field_form_name', 'religion', 'student_category_id', 'student_group_id', 'password'];

    public function studentCategory()
    {
        return $this->belongsTo(Studentcategory::class, 'student_category_id');
    }

    public function studentGroup()
    {
        return $this->belongsTo(Studentgroup::class, 'student_group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
    public function parents()
    {
        return $this->belongsToMany(
            StudentParent::class,
            'student_parents',
            'student_id',
            'parent_id'
        )->withPivot('relation', 'status');
    }

    public function idCards()
    {
        return $this->hasMany(StudentIdCard::class);
    }


    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function attendances()
    {
        return $this->hasMany(StudentAttendance::class, 'student_id', 'id');
    }
    public function studentAttendances()
    {
        return $this->hasMany(StudentAttendance::class);
    }

    public function enrollment()
{
    return $this->hasOne(Enrollment::class, 'student_id');
}

}

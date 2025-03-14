<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class Staff
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string|null $mobile
 * @property int|null $staff_no
 * @property bool $is_teaching
 * @property Carbon|null $dob
 * @property string|null $gender
 * @property string|null $blood_group
 * @property string|null $height
 * @property string|null $weight
 * @property Carbon|null $join_date
 * @property string|null $fathers_name
 * @property string|null $mothers_name
 * @property string|null $bank_account_name
 * @property string|null $bank_account_no
 * @property string|null $bank_name
 * @property string|null $bank_brach
 * @property string|null $ifsc_code
 * @property string|null $emergency_mobile
 * @property string|null $marital_status
 * @property string|null $staff_photo
 * @property string|null $current_address
 * @property string|null $permanent_address
 * @property string|null $qualification
 * @property string|null $experience
 * @property string|null $epf_no
 * @property string|null $basic_salary
 * @property string|null $contract_type
 * @property string|null $location
 * @property string|null $casual_leave
 * @property string|null $medical_leave
 * @property string|null $metarnity_leave
 * @property string|null $facebook_url
 * @property string|null $twiteer_url
 * @property string|null $linkedin_url
 * @property string|null $instragram_url
 * @property string|null $joining_letter
 * @property string|null $resume
 * @property string|null $other_document
 * @property string|null $notes
 * @property int $status
 * @property string|null $driving_license
 * @property Carbon|null $dl_expiry_date
 * @property string|null $custom_field
 * @property string|null $custom_field_form_name
 * @property int $user_id
 * @property int $institution_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Institution $institution
 * @property User $user
 * @property Collection|AdmissionFollowup[] $admission_followups
 * @property Collection|Admission[] $admissions
 * @property Collection|CourseRoutine[] $course_routines
 * @property Collection|Leaf[] $leaves
 * @property Collection|NoticeBoard[] $notice_boards
 * @property Collection|Payslip[] $payslips
 * @property Collection|StaffAttendance[] $staff_attendances
 * @property Collection|Course[] $courses
 * @property Collection|StudentHomework[] $student_homeworks
 * @property Collection|StudentIdCard[] $student_id_cards
 *
 * @package App\Models
 */
class Staff extends Authenticatable
{
    use Notifiable;
	protected $table = 'staffs';

	protected $casts = [
		'staff_no' => 'int',
		'is_teaching' => 'bool',
		'dob' => 'datetime',
		'join_date' => 'datetime',
		'status' => 'int',
		'dl_expiry_date' => 'datetime',
		'user_id' => 'int',
		'institution_id' => 'int'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'mobile',
		'staff_no',
		'is_teaching',
		'dob',
		'gender',
		'blood_group',
		'height',
		'weight',
		'join_date',
		'fathers_name',
		'mothers_name',
		'bank_account_name',
		'bank_account_no',
		'bank_name',
		'bank_brach',
		'ifsc_code',
		'emergency_mobile',
		'marital_status',
		'staff_photo',
		'current_address',
		'permanent_address',
		'qualification',
		'experience',
		'epf_no',
		'basic_salary',
		'contract_type',
		'location',
		'casual_leave',
		'medical_leave',
		'metarnity_leave',
		'facebook_url',
		'twiteer_url',
		'linkedin_url',
		'instragram_url',
		'joining_letter',
		'resume',
		'other_document',
		'notes',
		'status',
		'driving_license',
		'dl_expiry_date',
		'custom_field',
		'custom_field_form_name',
		'user_id',
		'institution_id'
	];

    protected static function boot()
    {
        parent::boot();
        static::created(function ($data) {
            $user = User::create([
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'password' => Hash::make('123456'),
                'mobile' => $data->mobile,
                'user_type' => 'staff',
            ]);
            DB::table('staffs')->where('email', $data->email)->update(['user_id' => $user->id]);
        });
    }

	public function institution()
	{
		return $this->belongsTo(Institution::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function admission_followups()
	{
		return $this->hasMany(AdmissionFollowup::class, 'updated_by');
	}

	public function admissions()
	{
		return $this->hasMany(Admission::class, 'updated_by');
	}

	public function course_routines()
	{
		return $this->hasMany(CourseRoutine::class);
	}

	public function leaves()
	{
		return $this->hasMany(Leaf::class);
	}

	public function notice_boards()
	{
		return $this->hasMany(NoticeBoard::class, 'updated_by');
	}

	public function payslips()
	{
		return $this->hasMany(Payslip::class);
	}

	public function staff_attendances()
	{
		return $this->hasMany(StaffAttendance::class);
	}

	public function courses()
	{
		return $this->belongsToMany(Course::class, 'staff_courses')
					->withPivot('id', 'status', 'institution_id')
					->withTimestamps();
	}

	public function student_homeworks()
	{
		return $this->hasMany(StudentHomework::class, 'evaluated_by');
	}

	public function student_id_cards()
	{
		return $this->hasMany(StudentIdCard::class);
	}

	public function attendances()
    {
        return $this->hasMany(StaffAttendance::class, 'staff_id', 'id');
    }

	public function routine()
	{
		return $this->hasMany(Routine::class, 'staff_id');
	}
}

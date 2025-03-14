<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        if (!Schema::hasTable('student_registration_fields')) {
            Schema::create('student_registration_fields', function (Blueprint $table) {
                $table->id();
                $table->string('field_name')->nullable();
                $table->string('label_name')->nullable();
                $table->tinyInteger('is_show')->nullable()->default(1);
                $table->tinyInteger('active_status')->nullable()->default(1);
                $table->tinyInteger('is_required')->nullable()->default(0);
                $table->tinyInteger('student_edit')->nullable()->default(0);
                $table->tinyInteger('parent_edit')->nullable()->default(0);
                $table->tinyInteger('staff_edit')->nullable()->default(0);
                $table->tinyInteger('type')->nullable()->comment('1=student, 2=staff');
                $table->tinyInteger('is_system_required')->nullable()->default(0);
                $table->tinyInteger('required_type')->nullable()->comment('1=switch on, 2=off');
                $table->integer('position')->nullable();
                $table->integer('created_by')->nullable()->default(1)->unsigned();
                $table->integer('updated_by')->nullable()->default(1)->unsigned();
                $table->foreignId('institution_id')->nullable()->constrained('institutions');
                $table->timestamps();
            });
        }


        $request_fields = [
            'roll_number',
            'admission_number',
            'first_name',
            'last_name',
            'gender',
            'date_of_birth',
            'blood_group',
            'email_address',
            'caste',
            'phone_number',
            'religion',
            'admission_date',
            'height',
            'weight',
            'photo',
            'parent_first_name',
            'parent_last_name',
            'parent_phone',
            'parent_email_address',
            'parent_gender',
            'current_address',
            'permanent_address',
            'national_id_number',
            'local_id_number',
            'previous_school_details',
            'additional_notes',
            'document_file_1',
            'document_file_2',
            'document_file_3',
            'document_file_4',
            'custom_field'
        ];


        $all_institutions = DB::table('institutions')->first();


        $institution_id = $all_institutions ? $all_institutions->id : null;


        foreach ($request_fields as $key => $field) {
            DB::table('student_registration_fields')->insert([
                'field_name' => $field,
                'label_name' => ucfirst(str_replace('_', ' ', $field)),
                'position' => $key + 1,
                'type' => 1,
                'institution_id' => $institution_id,
                'is_show' => 1,
                'active_status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::create('two_factor_settings', function (Blueprint $table) {
            $table->id();
            $table->boolean('via_sms')->default(0);
            $table->boolean('via_email')->default(1);
            $table->tinyInteger('for_student')->default(2);
            $table->tinyInteger('for_parent')->default(3);
            $table->tinyInteger('for_teacher')->default(4);
            $table->tinyInteger('for_staff')->default(6);
            $table->tinyInteger('for_admin')->default(1);
            $table->float('expired_time')->default(300);
            $table->foreignId('institution_id')->nullable()->constrained('institutions');
            $table->timestamps();
        });

        DB::table('two_factor_settings')->insert([
            'via_sms' => 0,
            'via_email' => 1,
            'for_student' => 1,
            'for_parent' => 1,
            'for_teacher' => 1,
            'for_staff' => 1,
            'for_admin' => 1,
            'expired_time' => 300,
            'institution_id' => $institution_id, 
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Schema::create('staff_registration_fields', function (Blueprint $table) {
            $table->id();
            $table->string('field_name')->nullable();
            $table->string('label_name')->nullable();
            $table->tinyInteger('active_status')->nullable()->default(1);
            $table->tinyInteger('is_required')->nullable()->default(0);
            $table->tinyInteger('staff_edit')->nullable()->default(0);
            $table->tinyInteger('required_type')->nullable()->comment('1=switch on,2=off');
            $table->integer('position')->nullable();

            $table->foreignId('institution_id')->nullable()->constrained('institutions');
          
            $table->timestamps();
        });

        $request_fields = [
            'blood_group',
            'staff_no',
            'height',
            'weight',
            'first_name',
            'last_name',
            'fathers_name',
            'mothers_name',
            'email',
            'gender',
            'dob',
            'join_date',
            'mobile',
            'marital_status',
            'emergency_mobile',
            'driving_license',
            'current_address',
            'permanent_address',
            'qualification',
            'experience',
            'epf_no',
            'basic_salary',
            'contract_type',
            'location',
            'bank_account_name',
            'bank_account_no',
            'bank_name',
            'bank_brach',
            'ifsc_code',
            'facebook_url',
            'twiteer_url', 
            'linkedin_url',
            'instragram_url', 
            'staff_photo',
            'resume',
            'joining_letter',
            'other_document',
            'custom_field', 
            'custom_field_form_name',
            'is_teaching',
            'status',
            'notes',
            'dl_expiry_date'
        ];
        

        foreach ($request_fields as $key => $field) {
            DB::table('staff_registration_fields')->insert([
                'field_name' => $field,
                'label_name' => ucfirst(str_replace('_', ' ', $field)),
                'active_status' => $key + 1,
                'required_type' => 1,
                'institution_id' => $institution_id,
                'active_status' => 1,
            ]);
        }
        

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('student_registration_fields');
        Schema::dropIfExists('two_factor_settings');
        Schema::dropIfExists('staff_registration_fields');        
    }
};

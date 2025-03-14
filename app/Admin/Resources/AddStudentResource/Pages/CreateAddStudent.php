<?php
namespace App\Admin\Resources\AddStudentResource\Pages;

use App\Admin\Resources\AddStudentResource;
use App\Models\Parents;
use App\Models\Smstudent;
use App\Models\Student;
use App\Models\StudentParent;
use App\Models\Studentparents;
use App\Models\User;
use Filament\Actions;
use Illuminate\Support\Facades\Hash;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateAddStudent extends CreateRecord {
    protected static string $resource = AddStudentResource::class;

    protected function handleRecordCreation(array $data): Student {
        return DB::transaction(function () use ($data) {
            $user = Auth::user();

        $username = strtolower(str_replace(' ', '', $data['first_name'] . ($data['last_name'] ?? '')));


        while (User::where('username', $username)->exists()) {
            $username = strtolower(str_replace(' ', '', $data['first_name'] . ($data['last_name'] ?? ''))) . rand(1000, 9999);
        }

        $userRecord = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'],
            'password' => Hash::make('123456'),
            'username' => $username,
            'mobile' => $data['mobile'] ?? null,
            'user_type' => 'student',
            'status' => 1,
        ]);

            $genderMap = [
                'male' => 'gender',
                'female' => 'female',
                'transgender' => 'transgender',
                'non-binary' => 'non-binary',
                'other' => 'other',
            ];

            $gender = $genderMap[$data['gender']] ?? 'other';

            $student = Student::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'] ?? null,
                'email' => $data['email'],
                'mobile' => $data['mobile'] ?? null,
                'admission_no' => $data['admission_no'] ?? null,
                'roll_no' => $data['roll_no'] ?? null,
                'admission_date' => $data['admission_date'] ?? null,
                'dob' => $data['dob'] ?? null,
                'gender' => $gender,
                'blood_group' => $data['blood_group'] ?? null,
                'height' => $data['height'] ?? null,
                'weight' => $data['weight'] ?? null,
                'current_address' => $data['current_address'] ?? null,
                'permanent_address' => $data['permanent_address'] ?? null,
                'national_id_no' => $data['national_id_no'] ?? null,
                'local_id_no' => $data['local_id_no'] ?? null,
                'religion' => $data['religion'] ?? null,
                'user_id' => $userRecord->id,
                'institution_id' => $user->institution_id ?? 1,


                'document_title_1' => $data['document_title_1'] ?? null,
                'document_file_1' => $data['document_file_1'] ? $data['document_file_1']->store('student_documents') : null,
                'document_title_2' => $data['document_title_2'] ?? null,
                'document_file_2' => $data['document_file_2'] ? $data['document_file_2']->store('student_documents') : null,
                'document_title_3' => $data['document_title_3'] ?? null,
                'document_file_3' => $data['document_file_3'] ? $data['document_file_3']->store('student_documents') : null,
                'document_title_4' => $data['document_title_4'] ?? null,
                'document_file_4' => $data['document_file_4'] ? $data['document_file_4']->store('student_documents') : null,


                'custom_field' => $data['custom_field'] ?? null,
                'custom_field_form_name' => $data['custom_field_form_name'] ?? null,
                'status' => 1,
            ]);


            if (!empty($data['parents'])) {
                foreach ($data['parents'] as $parentData) {
                    $parentGender = $genderMap[$parentData['gender']] ?? 'other';



                    $parent= StudentParent::create([
                        'first_name' => $parentData['first_name'],
                        'last_name' => $parentData['last_name'] ?? null,
                        'email' => $parentData['email'] ?? null,
                        'mobile' => $parentData['mobile'] ?? null,
                        'gender' => $parentGender,
                        'user_id'=>$student->user_id,
                        'institution_id' => $user->institution_id ?? 1,
                    ]);
                }
            }

           Studentparents::create([
            'student_id' => $student->id,
                'parent_id' => $parent->id,

                'status' => 1,
            ]);




            return $student;
        });
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

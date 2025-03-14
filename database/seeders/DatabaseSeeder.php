<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\InstitutionSeeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('optimize:clear');

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('users')->truncate();
        DB::table('institutions')->truncate();
        DB::table('permissions')->truncate();
        DB::table('role_has_permissions')->truncate();
        DB::table('model_has_permissions')->truncate();
        DB::table('model_has_roles')->truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);
        $parentRole = Role::firstOrCreate(['name' => 'parent']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);

        Permission::create(['name' => 'class-reports', 'guard_name' => 'web']);
        Permission::create(['name' => 'student-id-cards', 'guard_name' => 'web']);
        Permission::create(['name' => 'general-settings', 'guard_name' => 'web']);
        Permission::create(['name' => 'add-students', 'guard_name' => 'web']);
        Permission::create(['name' => 'certificates', 'guard_name' => 'web']);
        Permission::create(['name' => 'enrollments', 'guard_name' => 'web']);
        Permission::create(['name' => 'homework', 'guard_name' => 'web']);
        Permission::create(['name' => 'idcards', 'guard_name' => 'web']);
        Permission::create(['name' => 'studentcategories', 'guard_name' => 'web']);
        Permission::create(['name' => 'studentgroups', 'guard_name' => 'web']);
        Permission::create(['name' => 'study-materials', 'guard_name' => 'web']);
        Permission::create(['name' => 'un-approved-students', 'guard_name' => 'web']);
        Permission::create(['name' => 'student-attendances', 'guard_name' => 'web']);
        Permission::create(['name' => 'badges', 'guard_name' => 'web']);
        Permission::create(['name' => 'batches', 'guard_name' => 'web']);
        Permission::create(['name' => 'semesters', 'guard_name' => 'web']);
        Permission::create(['name' => 'programs', 'guard_name' => 'web']);
        Permission::create(['name' => 'sections', 'guard_name' => 'web']);
        Permission::create(['name' => 'courses', 'guard_name' => 'web']);
        Permission::create(['name' => 'modules', 'guard_name' => 'web']);
        Permission::create(['name' => 'lessons', 'guard_name' => 'web']);
        Permission::create(['name' => 'topics', 'guard_name' => 'web']);
        Permission::create(['name' => 'course-sections', 'guard_name' => 'web']);
        Permission::create(['name' => 'batch-programs', 'guard_name' => 'web']);
        Permission::create(['name' => 'assign-staff-batch-programs', 'guard_name' => 'web']);
        Permission::create(['name' => 'class-routines', 'guard_name' => 'web']);
        Permission::create(['name' => 'content-types', 'guard_name' => 'web']);
        Permission::create(['name' => 'contents', 'guard_name' => 'web']);
        Permission::create(['name' => 'video-uploads', 'guard_name' => 'web']);
        Permission::create(['name' => 'departments', 'guard_name' => 'web']);
        Permission::create(['name' => 'designations', 'guard_name' => 'web']);
        Permission::create(['name' => 'staff', 'guard_name' => 'web']);
        Permission::create(['name' => 'staff-attendances', 'guard_name' => 'web']);
        Permission::create(['name' => 'exam-signatures', 'guard_name' => 'web']);
        Permission::create(['name' => 'exam-types', 'guard_name' => 'web']);
        Permission::create(['name' => 'exams', 'guard_name' => 'web']);
        Permission::create(['name' => 'grades', 'guard_name' => 'web']);
        Permission::create(['name' => 'grade-setups', 'guard_name' => 'web']);
        Permission::create(['name' => 'leave-types', 'guard_name' => 'web']);
        Permission::create(['name' => 'leaves', 'guard_name' => 'web']);
        Permission::create(['name' => 'my-students', 'guard_name' => 'web']);
        Permission::create(['name' => 'routines', 'guard_name' => 'web']);
        Permission::create(['name' => 'online-exams', 'guard_name' => 'web']);
        Permission::create(['name' => 'online-assign-programs', 'guard_name' => 'web']);
        Permission::create(['name' => 'questions', 'guard_name' => 'web']);
        Permission::create(['name' => 'question-options', 'guard_name' => 'web']);
        Permission::create(['name' => 'online-exam-participants', 'guard_name' => 'web']);
        Permission::create(['name' => 'participant-answers', 'guard_name' => 'web']);
        Permission::create(['name' => 'roles', 'guard_name' => 'web']);
        Permission::create(['name' => 'permissions', 'guard_name' => 'web']);
        Permission::create(['name' => 'scholarships', 'guard_name' => 'web']);
        Permission::create(['name' => 'assign-scholarships', 'guard_name' => 'web']);
        Permission::create(['name' => 'stipends', 'guard_name' => 'web']);
        Permission::create(['name' => 'staff-attendance-reports', 'guard_name' => 'web']);
        Permission::create(['name' => 'student-histories', 'guard_name' => 'web']);
        Permission::create(['name' => 'studentlogins', 'guard_name' => 'web']);
        Permission::create(['name' => 'routines', 'guard_name' => 'student']);
        Permission::create(['name' => 'routines', 'guard_name' => 'staff']);
        Permission::create(['name' => 'my-students', 'guard_name' => 'parent']);
        Permission::create(['name' => 'my-students', 'guard_name' => 'staff']);
        Permission::create(['name' => 'my-programs', 'guard_name' => 'staff']);
        Permission::create(['name' => 'courses', 'guard_name' => 'student']);
        Permission::create(['name' => 'courses', 'guard_name' => 'parent']);
        Permission::create(['name' => 'apply-leaves', 'guard_name' => 'student']);
        Permission::create(['name' => 'apply-leaves', 'guard_name' => 'staff']);
        Permission::create(['name' => 'leaves', 'guard_name' => 'student']);
        Permission::create(['name' => 'leaves', 'guard_name' => 'parent']);
        Permission::create(['name' => 'leaves', 'guard_name' => 'staff']);
        Permission::create(['name' => 'attendances', 'guard_name' => 'staff']);
        Permission::create(['name' => 'attendance-reports', 'guard_name' => 'student']);
        Permission::create(['name' => 'attendance-reports', 'guard_name' => 'parent']);
        Permission::create(['name' => 'attendance-reports', 'guard_name' => 'staff']);

        if (!empty($adminRole)) {
            $admin_data = [];
            $admin_permission = Permission::where('guard_name', 'web')->get();
            foreach ($admin_permission as $value) {
                $admin_data[] = [
                    'permission_id' => $value->id,
                    'role_id' => 1,
                ];
            }
            DB::table('role_has_permissions')->insert($admin_data);
        } else {}


        if (!empty($studentRole)) {
            $student_data = [];
            $student_permission = Permission::where('guard_name', 'student')->get();
            foreach ($student_permission as $value) {
                $student_data[] = [
                    'permission_id' => $value->id,
                    'role_id' => 2,
                ];
            }
            DB::table('role_has_permissions')->insert($student_data);
        } else {}


        if (!empty($parentRole)) {
            $parent_data = [];
            $parent_permission = Permission::where('guard_name', 'parent')->get();
            foreach ($parent_permission as $value) {
                $parent_data[] = [
                    'permission_id' => $value->id,
                    'role_id' => 3,
                ];
            }
            DB::table('role_has_permissions')->insert($parent_data);
        } else {}

        if (!empty($teacherRole)) {
            $staff_data = [];
            $teacher_permission = Permission::where('guard_name', 'staff')->get();
            foreach ($teacher_permission as $value) {
                $staff_data[] = [
                    'permission_id' => $value->id,
                    'role_id' => 4,
                ];
            }
            DB::table('role_has_permissions')->insert($staff_data);
        } else {}


        $this->call(InstitutionSeeder::class);

    }
}

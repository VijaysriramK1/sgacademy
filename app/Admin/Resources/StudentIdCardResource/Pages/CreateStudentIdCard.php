<?php

namespace App\Admin\Resources\StudentIdCardResource\Pages;

use App\Admin\Resources\StudentIdCardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentIdCard extends CreateRecord
{
    protected static string $resource = StudentIdCardResource::class;
}

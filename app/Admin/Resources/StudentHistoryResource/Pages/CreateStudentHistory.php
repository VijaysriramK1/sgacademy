<?php

namespace App\Admin\Resources\StudentHistoryResource\Pages;

use App\Admin\Resources\StudentHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentHistory extends CreateRecord
{
    protected static string $resource = StudentHistoryResource::class;
}

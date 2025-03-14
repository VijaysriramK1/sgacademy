<?php

namespace App\Admin\Resources\StudentloginResource\Pages;

use App\Admin\Resources\StudentloginResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentlogin extends EditRecord
{
    protected static string $resource = StudentloginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

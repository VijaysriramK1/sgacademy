<?php

namespace App\Admin\Resources\StudentHistoryResource\Pages;

use App\Admin\Resources\StudentHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentHistory extends EditRecord
{
    protected static string $resource = StudentHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

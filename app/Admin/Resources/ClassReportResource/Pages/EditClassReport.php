<?php

namespace App\Admin\Resources\ClassReportResource\Pages;

use App\Admin\Resources\ClassReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditClassReport extends EditRecord
{
    protected static string $resource = ClassReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

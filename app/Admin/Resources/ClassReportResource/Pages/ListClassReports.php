<?php

namespace App\Admin\Resources\ClassReportResource\Pages;

use App\Admin\Resources\ClassReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClassReports extends ListRecords
{
    protected static string $resource = ClassReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

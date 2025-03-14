<?php

namespace App\Admin\Resources\EnrollmentResource\Pages;

use App\Admin\Resources\EnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnrollments extends ListRecords
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Assign Student')->icon('heroicon-m-plus'),
        ];
    }
}

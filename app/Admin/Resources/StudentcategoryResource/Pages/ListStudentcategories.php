<?php

namespace App\Admin\Resources\StudentcategoryResource\Pages;

use App\Admin\Resources\StudentcategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentcategories extends ListRecords
{
    protected static string $resource = StudentcategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

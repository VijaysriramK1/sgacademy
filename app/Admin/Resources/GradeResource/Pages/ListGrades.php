<?php

namespace App\Admin\Resources\GradeResource\Pages;

use App\Admin\Resources\GradeResource;
use App\Admin\Resources\GradeSetupResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGrades extends ListRecords
{
    protected static string $resource = GradeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Grade Setup')
            ->label('Grade Setup')
            ->url(GradeSetupResource::getUrl('index'))->icon('heroicon-m-cog'),
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

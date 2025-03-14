<?php

namespace App\Admin\Resources\ExamTypeResource\Pages;

use App\Admin\Resources\ExamResource;
use App\Admin\Resources\ExamSetupResource;
use App\Admin\Resources\ExamTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExamTypes extends ListRecords
{
    protected static string $resource = ExamTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
           
            Actions\Action::make('Add Exam')
                ->label('Add Exam')
                ->url(ExamResource::getUrl('index'))->icon('heroicon-m-plus'),
                Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}
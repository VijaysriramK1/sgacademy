<?php

namespace App\Admin\Resources\QuestionResource\Pages;

use App\Admin\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Create Questions')->icon('heroicon-m-plus'),
        ];
    }
}

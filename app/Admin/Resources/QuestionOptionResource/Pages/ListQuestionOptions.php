<?php

namespace App\Admin\Resources\QuestionOptionResource\Pages;

use App\Admin\Resources\QuestionOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuestionOptions extends ListRecords
{
    protected static string $resource = QuestionOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Question Option'),
        ];
    }
}

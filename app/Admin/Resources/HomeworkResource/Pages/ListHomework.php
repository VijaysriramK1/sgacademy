<?php

namespace App\Admin\Resources\HomeworkResource\Pages;

use App\Admin\Resources\HomeworkResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomework extends ListRecords
{
    protected static string $resource = HomeworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

<?php

namespace App\Admin\Resources\OnlineExamResource\Pages;

use App\Admin\Resources\OnlineExamResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOnlineExams extends ListRecords
{
    protected static string $resource = OnlineExamResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

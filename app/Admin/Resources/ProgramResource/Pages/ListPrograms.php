<?php

namespace App\Admin\Resources\ProgramResource\Pages;

use App\Admin\Resources\ProgramResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrograms extends ListRecords
{
    protected static string $resource = ProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

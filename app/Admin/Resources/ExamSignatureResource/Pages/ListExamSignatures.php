<?php

namespace App\Admin\Resources\ExamSignatureResource\Pages;

use App\Admin\Resources\ExamSignatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListExamSignatures extends ListRecords
{
    protected static string $resource = ExamSignatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label('Add Signature'),
        ];
    }
}

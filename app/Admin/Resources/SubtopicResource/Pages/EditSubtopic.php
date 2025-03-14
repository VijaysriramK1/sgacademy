<?php

namespace App\Admin\Resources\SubtopicResource\Pages;

use App\Admin\Resources\SubtopicResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubtopic extends EditRecord
{
    protected static string $resource = SubtopicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

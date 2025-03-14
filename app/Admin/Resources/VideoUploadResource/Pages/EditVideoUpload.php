<?php

namespace App\Admin\Resources\VideoUploadResource\Pages;

use App\Admin\Resources\VideoUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVideoUpload extends EditRecord
{
    protected static string $resource = VideoUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

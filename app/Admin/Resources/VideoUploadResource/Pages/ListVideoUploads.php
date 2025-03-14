<?php

namespace App\Admin\Resources\VideoUploadResource\Pages;

use App\Admin\Resources\VideoUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVideoUploads extends ListRecords
{
    protected static string $resource = VideoUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

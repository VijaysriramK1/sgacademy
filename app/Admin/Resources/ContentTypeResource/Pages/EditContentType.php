<?php

namespace App\Admin\Resources\ContentTypeResource\Pages;

use App\Admin\Resources\ContentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContentType extends EditRecord
{
    protected static string $resource = ContentTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

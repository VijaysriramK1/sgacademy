<?php

namespace App\Admin\Resources\ContentTypeResource\Pages;

use App\Admin\Resources\ContentTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContentType extends CreateRecord
{
    protected static string $resource = ContentTypeResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

<?php

namespace App\Admin\Resources\FeesTypeResource\Pages;

use App\Admin\Resources\FeesTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeesType extends EditRecord
{
    protected static string $resource = FeesTypeResource::class;

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

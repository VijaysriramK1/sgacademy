<?php

namespace App\Admin\Resources\FeesGroupResource\Pages;

use App\Admin\Resources\FeesGroupResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeesGroup extends EditRecord
{
    protected static string $resource = FeesGroupResource::class;

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

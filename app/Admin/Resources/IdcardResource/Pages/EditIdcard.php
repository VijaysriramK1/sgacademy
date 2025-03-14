<?php

namespace App\Admin\Resources\IdcardResource\Pages;

use App\Admin\Resources\IdcardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIdcard extends EditRecord
{
    protected static string $resource = IdcardResource::class;

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

<?php

namespace App\Admin\Resources\FeesInvoiceResource\Pages;

use App\Admin\Resources\FeesInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeesInvoice extends EditRecord
{
    protected static string $resource = FeesInvoiceResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\DeleteAction::make(),
    //     ];
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

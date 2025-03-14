<?php

namespace App\Admin\Resources\FeesInvoiceResource\Pages;

use App\Admin\Resources\FeesInvoiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFeesInvoices extends ListRecords
{
    protected static string $resource = FeesInvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->Label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

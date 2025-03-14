<?php

namespace App\Admin\Resources\IdcardResource\Pages;

use App\Admin\Resources\IdcardResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIdcards extends ListRecords
{
    protected static string $resource = IdcardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

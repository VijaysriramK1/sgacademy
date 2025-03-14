<?php

namespace App\Admin\Resources\AdmissionQueryResource\Pages;

use App\Admin\Resources\AdmissionQueryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdmissionQueries extends ListRecords
{
    protected static string $resource = AdmissionQueryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add'),
        ];
    }
}

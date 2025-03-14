<?php

namespace App\Admin\Resources\AdmissionFeesResource\Pages;

use App\Admin\Resources\AdmissionFeesResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAdmissionFees extends ListRecords
{
    protected static string $resource = AdmissionFeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->Label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

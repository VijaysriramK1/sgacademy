<?php

namespace App\Admin\Resources\ScholarshipResource\Pages;

use App\Admin\Resources\ScholarshipResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScholarships extends ListRecords
{
    protected static string $resource = ScholarshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

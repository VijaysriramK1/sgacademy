<?php

namespace App\Admin\Resources\ScholarshipResource\Pages;

use App\Admin\Resources\ScholarshipResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditScholarship extends EditRecord
{
    protected static string $resource = ScholarshipResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

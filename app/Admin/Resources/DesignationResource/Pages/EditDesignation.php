<?php

namespace App\Admin\Resources\DesignationResource\Pages;

use App\Admin\Resources\DesignationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDesignation extends EditRecord
{
    protected static string $resource = DesignationResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}

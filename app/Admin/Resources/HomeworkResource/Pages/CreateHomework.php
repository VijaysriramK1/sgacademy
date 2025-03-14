<?php

namespace App\Admin\Resources\HomeworkResource\Pages;

use App\Admin\Resources\HomeworkResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHomework extends CreateRecord
{
    protected static string $resource = HomeworkResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

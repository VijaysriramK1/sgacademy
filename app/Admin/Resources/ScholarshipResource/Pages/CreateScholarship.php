<?php

namespace App\Admin\Resources\ScholarshipResource\Pages;

use App\Admin\Resources\ScholarshipResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateScholarship extends CreateRecord
{
    protected static string $resource = ScholarshipResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()->visible(false);
    }
}

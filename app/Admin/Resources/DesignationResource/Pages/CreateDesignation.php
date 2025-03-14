<?php

namespace App\Admin\Resources\DesignationResource\Pages;

use App\Admin\Resources\DesignationResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateDesignation extends CreateRecord
{
    protected static string $resource = DesignationResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()->visible(false);
    }
}

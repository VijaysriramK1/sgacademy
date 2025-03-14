<?php

namespace App\Admin\Resources\DepartmentResource\Pages;

use App\Admin\Resources\DepartmentResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()->visible(false);
    }
}

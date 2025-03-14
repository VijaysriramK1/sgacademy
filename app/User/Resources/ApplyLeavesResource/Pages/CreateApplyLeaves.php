<?php

namespace App\User\Resources\ApplyLeavesResource\Pages;

use App\User\Resources\ApplyLeavesResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateApplyLeaves extends CreateRecord
{
    protected static string $resource = ApplyLeavesResource::class;

    public function getBreadcrumbs(): array
    {
      return [
        '#' => 'Leave',
        '/apply-leaves' => 'Apply Leave',
      ];
    }

    protected function getCreateAnotherFormAction(): Action
    {
        return parent::getCreateAnotherFormAction()->visible(false);
    }

    public function getHeading(): string
    {
        return 'Apply Leave';
    }

    protected function getRedirectUrl(): string
    {
       return \App\User\Resources\LeaveResource::getUrl('index');
    }


}

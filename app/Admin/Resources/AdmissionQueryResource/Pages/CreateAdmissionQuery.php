<?php

namespace App\Admin\Resources\AdmissionQueryResource\Pages;

use App\Admin\Resources\AdmissionQueryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateAdmissionQuery extends CreateRecord
{
    protected static string $resource = AdmissionQueryResource::class;
}

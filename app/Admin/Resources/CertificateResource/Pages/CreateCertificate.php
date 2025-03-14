<?php

namespace App\Admin\Resources\CertificateResource\Pages;

use App\Admin\Resources\CertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificate extends CreateRecord
{
    protected static string $resource = CertificateResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

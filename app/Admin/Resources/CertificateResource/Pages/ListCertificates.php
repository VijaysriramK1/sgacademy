<?php

namespace App\Admin\Resources\CertificateResource\Pages;

use App\Admin\Resources\CertificateResource;
use App\Models\Student;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\DB;
use App\Models\Studentparents;


class ListCertificates extends ListRecords
{
    protected static string $resource = CertificateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
        ];
    }
   
}

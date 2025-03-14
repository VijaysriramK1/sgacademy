<?php

namespace App\Admin\Resources\StudentSettingResource\Pages;

use App\Admin\Resources\StudentSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentSettings extends ListRecords
{
    protected static string $resource = StudentSettingResource::class;

    protected static ?string $title = 'Student Setting';

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}

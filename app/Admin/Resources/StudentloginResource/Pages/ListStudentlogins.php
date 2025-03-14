<?php

namespace App\Admin\Resources\StudentloginResource\Pages;

use App\Admin\Resources\StudentloginResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentlogins extends ListRecords
{
    protected static string $resource = StudentloginResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}

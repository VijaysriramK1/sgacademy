<?php

namespace App\Admin\Resources\StudentHistoryResource\Pages;

use App\Admin\Resources\StudentHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentHistories extends ListRecords
{
    protected static string $resource = StudentHistoryResource::class;

    protected static ?string $title = 'Student history';


    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make(),
    //     ];
    // }
}

<?php

namespace App\Admin\Resources\TopicResource\Pages;

use App\Admin\Resources\TopicResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTopics extends ListRecords
{
    protected static string $resource = TopicResource::class;

    // protected function getHeaderActions(): array
    // {
    //     return [
    //         Actions\CreateAction::make()->label('Add')->icon('heroicon-m-plus'),
    //     ];
    // }
}

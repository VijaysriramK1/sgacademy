<?php

namespace App\Admin\Resources\OnlineExamParticipantResource\Pages;

use App\Admin\Resources\OnlineExamParticipantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOnlineExamParticipants extends ListRecords
{
    protected static string $resource = OnlineExamParticipantResource::class;

    protected static ?string $title = 'Participant';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Participant')->icon('heroicon-m-plus'),
        ];
    }
}

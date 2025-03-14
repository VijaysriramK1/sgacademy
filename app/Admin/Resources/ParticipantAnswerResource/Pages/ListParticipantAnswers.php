<?php

namespace App\Admin\Resources\ParticipantAnswerResource\Pages;

use App\Admin\Resources\ParticipantAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListParticipantAnswers extends ListRecords
{
    protected static string $resource = ParticipantAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Participant Answer'),
        ];
    }
}

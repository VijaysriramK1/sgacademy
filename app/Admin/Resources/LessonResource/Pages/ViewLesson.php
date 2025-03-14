<?php

namespace App\Admin\Resources\LessonResource\Pages;

use App\Admin\Resources\LessonResource;
use App\Admin\Resources\LessonResource\RelationManagers\TopicsRelationManager;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

class ViewLesson extends ViewRecord
{
    protected static string $resource = LessonResource::class;

    public function getRelationManagers(): array
    {
        return [
            TopicsRelationManager::class
        ];
    }

    
}

<?php
namespace App\Admin\Resources\LessonResource\Pages;

use App\Admin\Resources\TopicResource;
use Filament\Resources\Pages\ViewRecord;
use App\Admin\Resources\LessonResource\RelationManagers\SubTopicRelationManager;

class ViewSubtopic extends ViewRecord
{
    protected static string $resource = TopicResource::class;

    public function getRelationManagers(): array
    {
        return [
            SubTopicRelationManager::class,
        ];
    }
}

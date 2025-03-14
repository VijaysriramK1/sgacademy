<?php

namespace App\Admin\Resources\TopicResource\Pages;

use App\Admin\Resources\TopicResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTopic extends CreateRecord
{
    protected static string $resource = TopicResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

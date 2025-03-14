<?php

namespace App\Admin\Resources\SubtopicResource\Pages;

use App\Admin\Resources\SubtopicResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSubtopic extends CreateRecord
{
    protected static string $resource = SubtopicResource::class;
}

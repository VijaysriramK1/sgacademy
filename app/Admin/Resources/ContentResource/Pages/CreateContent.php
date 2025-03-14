<?php

namespace App\Admin\Resources\ContentResource\Pages;

use App\Admin\Resources\ContentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateContent extends CreateRecord
{
    protected static string $resource = ContentResource::class;
}

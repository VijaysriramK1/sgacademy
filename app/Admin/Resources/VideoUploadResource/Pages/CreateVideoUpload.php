<?php

namespace App\Admin\Resources\VideoUploadResource\Pages;

use App\Admin\Resources\VideoUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateVideoUpload extends CreateRecord
{
    protected static string $resource = VideoUploadResource::class;
}

<?php

namespace App\Admin\Resources\IdcardResource\Pages;

use App\Admin\Resources\IdcardResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIdcard extends CreateRecord
{
    protected static string $resource = IdcardResource::class;
}

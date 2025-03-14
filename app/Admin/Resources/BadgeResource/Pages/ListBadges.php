<?php

namespace App\Admin\Resources\BadgeResource\Pages;

use App\Admin\Resources\BadgeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use PhpParser\Node\Stmt\Label;

class ListBadges extends ListRecords
{
    protected static string $resource = BadgeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->Label('Add')->icon('heroicon-m-plus'),
        ];
    }
}

<?php

namespace App\Admin\Resources\ContentResource\Pages;

use App\Admin\Resources\ContentResource;
use App\Models\Content;
use App\Models\ContentShare;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ListContents extends ListRecords
{
    protected static string $resource = ContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Content List')
                ->modifyQueryUsing(fn ($query) => $query)
                ->badge($this->getContentCount()),
    
            'shared' => Tab::make('Shared Content List')
                ->modifyQueryUsing(function ($query) {
                  
                    return ContentShare::query(); 
                })
                ->badge($this->getSharedContentCount())
        ];
    }
    

    protected function getContentCount(): int
    {
        return Content::query()->count();
    }

    protected function getSharedContentCount(): int
    {
        return DB::table('content_share_lists')->count(); 
    }
}
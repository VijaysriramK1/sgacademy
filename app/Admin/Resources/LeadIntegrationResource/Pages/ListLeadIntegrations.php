<?php

namespace App\Admin\Resources\LeadIntegrationResource\Pages;

use App\Admin\Resources\LeadIntegrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLeadIntegrations extends ListRecords
{
    protected static string $resource = LeadIntegrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add')
               , 
        ];
    }
    
}

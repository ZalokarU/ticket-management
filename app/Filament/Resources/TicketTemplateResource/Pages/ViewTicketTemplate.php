<?php

namespace App\Filament\Resources\TicketTemplateResource\Pages;

use App\Filament\Resources\TicketTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTicketTemplate extends ViewRecord
{
    protected static string $resource = TicketTemplateResource::class;

    /**
     * Actions visible at the top of the View page.
     */
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}

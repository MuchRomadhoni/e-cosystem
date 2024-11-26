<?php

namespace App\Filament\Resources\KantorResource\Pages;

use App\Filament\Resources\KantorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKantor extends EditRecord
{
    protected static string $resource = KantorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

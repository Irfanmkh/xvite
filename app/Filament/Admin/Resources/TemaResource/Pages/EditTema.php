<?php

namespace App\Filament\Admin\Resources\TemaResource\Pages;

use App\Filament\Admin\Resources\TemaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTema extends EditRecord
{
    protected static string $resource = TemaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

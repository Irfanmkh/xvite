<?php

namespace App\Filament\Admin\Resources\FormfieldsResource\Pages;

use App\Filament\Admin\Resources\FormfieldsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFormfields extends EditRecord
{
    protected static string $resource = FormfieldsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}

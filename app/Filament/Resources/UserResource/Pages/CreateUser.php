<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // 🔥 FIX: Le decimos a Filament que después de crear, vuelva a la tabla (index)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
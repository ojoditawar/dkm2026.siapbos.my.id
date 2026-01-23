<?php

namespace App\Filament\Resources\DetilAsnafs\Pages;

use App\Filament\Resources\DetilAsnafs\DetilAsnafResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDetilAsnaf extends CreateRecord
{
    protected static string $resource = DetilAsnafResource::class;

    protected static bool $canCreate = false;
    protected static bool $canCreateAnother = false;
    protected static bool $canCancel = false;
}

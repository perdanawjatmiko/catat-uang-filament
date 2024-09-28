<?php

namespace App\Filament\Resources\AccountResource\Pages;

use App\Filament\Resources\AccountResource;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageAccounts extends ManageRecords
{
    protected static string $resource = AccountResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            AccountResource\Widgets\AccountData::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                $data['user_id'] = Auth::user()->id;
                return $data;
            }),
        ];
    }
}

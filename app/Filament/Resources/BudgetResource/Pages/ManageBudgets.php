<?php

namespace App\Filament\Resources\BudgetResource\Pages;

use App\Filament\Resources\BudgetResource;
use App\Models\Budget;
use Filament\Actions;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Support\Facades\Auth;

class ManageBudgets extends ManageRecords
{
    protected static string $resource = BudgetResource::class;

    use ExposesTableToWidgets;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                $data['user_id'] = Auth::user()->id;
                return $data;
            }),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            BudgetResource\Widgets\TotalBudgetStat::class,
        ];
    }
}

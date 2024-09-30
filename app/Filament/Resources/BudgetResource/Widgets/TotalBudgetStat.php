<?php

namespace App\Filament\Resources\BudgetResource\Widgets;

use App\Filament\Resources\BudgetResource\Pages\ManageBudgets;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Budget;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Illuminate\Support\Facades\Auth;

class TotalBudgetStat extends BaseWidget
{
    use InteractsWithPageTable;

    protected function getTablePage(): string
    {
        return ManageBudgets::class;
    }
    protected function getStats(): array
    {
        $getBudget = Budget::where('user_id', Auth::user()->id)->get();
        $totalBudget = $this->getPageTableQuery()->sum('amount_target');
        $totalSpent = $this->getPageTableQuery()->sum('amount_now');
        $percent = round(($totalSpent / $totalBudget) * 100, 2);

        return [
            Stat::make('Total Budgets', 'Rp. '. number_format($totalBudget, 0, '.', '.')),
            Stat::make('Total Spent', 'Rp. '. number_format($totalSpent, 0, '.', '.')),
            Stat::make('Total Completion', $percent . '%')->color('success'),
        ];
    }
}

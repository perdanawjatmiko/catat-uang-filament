<?php

namespace App\Filament\Resources\BudgetResource\Widgets;

use App\Filament\Resources\BudgetResource\Pages\ManageBudgets;
use Filament\Widgets\Concerns\InteractsWithPageTable;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TotalSpentStat extends BaseWidget
{

    use InteractsWithPageTable;
    protected function getTablePage(): string
    {
        return ManageBudgets::class;
    }

    protected function getStats(): array
    {
        $totalSpent = $this->getPageTableQuery()->sum('amount_now');
        
        return [
            Stat::make('Total Spent', 'Rp. '. number_format($totalSpent, 0, '.', '.')),
        ];
    }
}

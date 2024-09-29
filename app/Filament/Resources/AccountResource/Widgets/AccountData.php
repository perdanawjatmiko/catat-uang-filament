<?php

namespace App\Filament\Resources\AccountResource\Widgets;

use App\Models\Account;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class AccountData extends BaseWidget
{
    protected static ?string $model = Account::class;

    protected function getStats(): array
    {
        $accounts = Account::where('user_id', Auth::user()->id)->get();

        $totalBalance = 'Rp. '. number_format($accounts->sum('balance'), 0, '.', '.');

        return [
            Stat::make('Total Balance', $totalBalance)
                ->description('Total Balance of your accounts')
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->color('success'),
        ];
    }
}

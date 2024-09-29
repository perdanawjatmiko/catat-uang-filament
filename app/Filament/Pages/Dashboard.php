<?php

namespace App\Filament\Pages;

use App\Filament\Resources\AccountResource\Widgets\AccountData;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\Auth;

// use Filament\Pages\Page;

class Dashboard extends \Filament\Pages\Dashboard
{
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    public function getTitle(): string | Htmlable
    {
        return 'Dashboard';
    }

    public function getHeading(): string | Htmlable
    {
        return __('Welcome '.(Auth::user()->name ?? ''));
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AccountData::class
        ];
    }
    
}

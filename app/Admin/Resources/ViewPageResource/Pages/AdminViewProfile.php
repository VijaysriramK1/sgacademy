<?php

namespace App\Admin\Pages;

use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminViewProfile extends Page
{
    protected static ?string $title = 'Profile';
    protected static ?string $navigationLabel = 'Profile';
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static string $view = 'admin-view-page';

    public User $user;

    public static function getLabel(): string
    {
        return __('Profile');
    }

    public function mount(): void
    {
        $this->user = Auth::user();
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->user) 
            ->schema([
                TextEntry::make('first_name')
                    ->label(__('First Name')),

                TextEntry::make('last_name')
                    ->label(__('Last Name')),

                TextEntry::make('username')
                    ->label(__('Username')),

                TextEntry::make('email')
                    ->label(__('Email Address')),

                TextEntry::make('created_at')
                    ->label(__('Account Created At'))
                    ->date(),

                TextEntry::make('updated_at')
                    ->label(__('Last Updated At'))
                    ->date(),
            ]);
    }
}
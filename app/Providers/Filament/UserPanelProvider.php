<?php

namespace App\Providers\Filament;

use App\Helpers\UserHelper;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Filament\Navigation\MenuItem;
use Illuminate\Support\Facades\Auth;
use App\User\Pages\Auth\UserLogin;
use App\User\Pages\Dashboard;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class UserPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('user')
            ->path('')
            ->login(UserLogin::class)
            ->sidebarCollapsibleOnDesktop()
            ->sidebarWidth("250px")
            ->favicon(asset('/logo/SG logo.png'))
            ->brandLogo(asset('/logo/SG logo.png'))
            ->colors([
                'primary' => Color::Indigo,
            ])
            ->discoverResources(in: app_path('User/Resources'), for: 'App\\User\\Resources')
            ->discoverPages(in: app_path('User/Pages'), for: 'App\\User\\Pages')
            ->discoverClusters(in: app_path('User/Clusters'), for: 'App\\User\\Clusters')
            ->pages([
                Dashboard::class,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                ->label(fn (): string => UserHelper::currentRoleDetails()->first_name . ' ' . UserHelper::currentRoleDetails()->last_name)
                ->icon('heroicon-o-user')
                ->url('#'),

                'logout' => MenuItem::make()
                    ->label('Sign Out')
                    ->url(fn(): string => route('user.logout'))
            ])
            ->discoverWidgets(in: app_path('User/Widgets'), for: 'App\\User\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
            ->plugins([FilamentFullCalendarPlugin::make()])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->authGuard('web');
    }
}

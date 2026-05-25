<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Dashboard;
use App\Filament\Pages\EnvEditorPage;
use App\Filament\Pages\GeneralSettingsPage;
use App\Services\GeneralSettingsService;
use Awcodes\Curator\CuratorPlugin;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Filament\Auth\MultiFactor\App\AppAuthentication;
use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Forms\Components\FileUpload;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use GeoSot\FilamentEnvEditor\FilamentEnvEditorPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Jeffgreco13\FilamentBreezy\BreezyCore;
use Leandrocfe\FilamentApexCharts\FilamentApexChartsPlugin;

class AdminPanelProvider extends PanelProvider
{
    protected ?array $data;

    public function panel(Panel $panel): Panel
    {
        $this->data = app(GeneralSettingsService::class)->get('site');

        return $panel
            // General
            ->default()
            ->id($this->data['dashboard_url'] ?? 'admin')
            ->path($this->data['dashboard_url'] ?? 'admin')
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->brandName($this->data['name'] ?? config('app.name'))
            ->favicon(fn () =>
                $this->data['favicon'] ? Storage::url($this->data['favicon']) : null
            )
            ->brandLogo(fn () =>
                $this->data['logo'] ? Storage::url($this->data['logo']) : null
            )

            // Authentication
            ->login()
            ->registration()
            ->passwordReset()
            ->emailVerification()
            ->emailChangeVerification()
            ->profile(isSimple: false)
            ->authGuard('web')
            ->multiFactorAuthentication([
                EmailAuthentication::make()
                    ->codeExpiryMinutes(2),
                AppAuthentication::make()
                    ->brandName('Filament Demo')
                    ->codeWindow(4)
                    ->recoverable()
                    ->recoveryCodeCount(10)
                    ->regenerableRecoveryCodes(false),
            ], isRequired: false)

            // Authentication Routes
            ->loginRouteSlug('login')
            ->registrationRouteSlug('register')
            ->passwordResetRoutePrefix('password-reset')
            ->passwordResetRequestRouteSlug('request')
            ->passwordResetRouteSlug('reset')
            ->emailVerificationRoutePrefix('email-verification')
            ->emailVerificationPromptRouteSlug('prompt')
            ->emailVerificationRouteSlug('verify')
            ->emailChangeVerificationRoutePrefix('email-change-verification')
            ->emailChangeVerificationRouteSlug('verify')

            // Resources
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')

            // Pages
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
                GeneralSettingsPage::class,
            ])

            // Widgets
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                //
            ])

            // Navigation
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Settings'),
                NavigationGroup::make()
                    ->label('Accounts'),
                NavigationGroup::make()
                    ->label('Pages'),
                NavigationGroup::make()
                    ->label('Posts'),
                NavigationGroup::make()
                    ->label('Storages'),
            ])
            ->navigationItems([
                NavigationItem::make('Go to web')
                    ->url('/', shouldOpenInNewTab: true)
                    ->icon(Heroicon::OutlinedGlobeAlt)
                    ->sort(-1),
            ])

            // Misc
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
            ->plugins([
                BreezyCore::make()
                    // ->customMyProfilePage(AccountSettingsPage::class)
                    ->myProfile(
                        shouldRegisterUserMenu: true,
                        userMenuLabel: 'My Profile',
                        shouldRegisterNavigation: false,
                        navigationGroup: 'Settings',
                        hasAvatars: true,
                        slug: 'my-profile'
                    )
                    ->avatarUploadComponent(fn() =>
                        FileUpload::make('avatar_url')
                            ->disk('avatars')
                            ->label('Avatar')
                            ->image()
                            ->maxSize(1024)
                    )
                    ->passwordUpdateRules(
                        rules: [Password::default()->mixedCase()->uncompromised(3)],
                        requiresCurrentPassword: true,
                    )
                    ->enableTwoFactorAuthentication(
                        condition: false,
                        force: false,
                        // action: CustomTwoFactorPage::class,
                        // authMiddleware: MustTwoFactor::class,
                        scopeToPanel: true,
                    )
                    ->enableSanctumTokens(
                        condition: false,
                        permissions: ["create", "view", "update", "delete"]
                    )
                    ->enablePasskeys(
                        condition: false,
                        relyingPartyName: $this->data['name'] ?? config('app.name'),
                        relyingPartyId: $this->data['url'] ?? config('app.url'),
                        relyingPartyIcon: $this->data['logo'] ? Storage::url($this->data['logo']) : null,
                        scopeToPanel: true,
                    )
                    ->enableBrowserSessions(
                        condition: false
                    ),
                FilamentShieldPlugin::make()
                    ->navigationLabel('Roles')
                    ->navigationIcon(Heroicon::OutlinedShieldCheck)
                    ->activeNavigationIcon(Heroicon::ShieldCheck)
                    ->navigationGroup('Accounts')
                    ->navigationSort(2)
                    ->gridColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 3
                    ])
                    ->sectionColumnSpan(1)
                    ->checkboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                        'lg' => 4,
                    ])
                    ->resourceCheckboxListColumns([
                        'default' => 1,
                        'sm' => 2,
                    ]),
                FilamentEnvEditorPlugin::make()
                    ->navigationGroup('Settings')
                    ->navigationLabel('Environment')
                    ->navigationIcon('heroicon-o-cog-6-tooth')
                    ->navigationSort(2)
                    ->slug('environment')
                    ->viewPage(EnvEditorPage::class)
                    ->hideKeys(
                        'APP_MAINTENANCE_DRIVER',
                        '# APP_MAINTENANCE_STORE',
                        'PHP_CLI_SERVER_WORKERS',
                        'BCRYPT_ROUNDS'
                    ),
                CuratorPlugin::make()
                    ->label('Media')
                    ->pluralLabel('Media')
                    ->navigationIcon('heroicon-o-photo')
                    ->navigationGroup('Storages')
                    ->navigationSort(1)
                    ->showBadge(false)
                    ->registerNavigation(true)
                    ->curations(true)
                    ->fileSwap(true),
                // FilamentApexChartsPlugin::make(),
            ]);
    }
}

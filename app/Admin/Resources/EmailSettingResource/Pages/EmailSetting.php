<?php

namespace App\Admin\Clusters\Settings\Pages;

use App\Admin\Clusters\GeneralSettings;
use App\Admin\Clusters\Settings;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use App\Helpers\EnvUpdate;
use Illuminate\Support\Str;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use App\Filament\Clusters\Settings\Forms\EmailFieldsForm;

class EmailSetting extends Page implements HasForms
{
    
    protected static ?string $navigationIcon = '';

    protected static string $view = 'email_setting';

    protected static ?string $cluster = GeneralSettings::class;

    protected static ?int $navigationSort = 4;

    public $email_smtp;
    public $mail_host;
    public $mail_port;
    public $mail_username;
    public $mail_password;
    public $mail_encryption;
    public $mail_from_address;

    public ?array $data = [];

    public function mount(): void
    {
        $this->email_smtp = env('MAIL_MAILER', 'smtp');
        $this->mail_host = env('MAIL_HOST', '121.0.0.1');
        $this->mail_port = env('MAIL_PORT', null);
        $this->mail_username = env('MAIL_USERNAME', null);
        $this->mail_password = env('MAIL_PASSWORD', null);
        $this->mail_encryption = env('MAIL_ENCRYPTION', 'tls');
        $this->mail_from_address = env('MAIL_FROM_ADDRESS', 'support@example.com');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    Forms\Components\TextInput::make('email_smtp')
                        ->label('Mail Driver')
                        ->required(),
                    Forms\Components\TextInput::make('mail_host')
                        ->label('Host')
                        ->required(),
                    Forms\Components\TextInput::make('mail_port')
                        ->label('Port')
                        ->required(),
                    Forms\Components\TextInput::make('mail_username')
                        ->label('Username')
                        ->required(),
                    Forms\Components\TextInput::make('mail_password')
                        ->label('Password')
                        ->password()
                        ->required(),
                    Forms\Components\TextInput::make('mail_encryption')
                        ->label('Email Encryption')
                        ->required(),
                    Forms\Components\TextInput::make('mail_from_address')
                        ->label('Sender Email')
                        ->email()
                        ->required(),
                ])
                    ->columnSpan(2)
            ]);
    }

    public function submit()
    {
        $items = $this->form->getState();
        foreach ($items as $key => $value) {
            EnvUpdate::set(Str::upper($key), str_replace('#', '', $value));
        }
        Artisan::call('cache:clear');

        Notification::make()
            ->title('Email settings updated!')
            ->success()
            ->send();
    }
}
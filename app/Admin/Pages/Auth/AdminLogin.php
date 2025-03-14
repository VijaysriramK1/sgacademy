<?php

namespace App\Admin\Pages\Auth;

use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login;
use App\Models\User;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminLogin extends Login
{
    public function form(Form $form): Form
    {
        $schema = [
            $this->getEmailFormComponent()->label('Email Address'),
            $this->getPasswordFormComponent()->label('Password'),
            $this->getRememberFormComponent(),
        ];

        return $form->schema($schema)->statePath('data');
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'email' => $data['email'],
            'password' => $data['password'],
        ];
    }

    public function authenticate(): ?LoginResponse
    {
        $this->validate();

        $credentials = $this->getCredentialsFromFormData($this->data);
        $email = $credentials['email'];
        $password = $credentials['password'];

        $check_data = User::where('email', $email)->first();

        if (!empty($check_data)) {
            if (Hash::check($password, $check_data->password)) {

                if ($check_data->is_admin == 1) {
                    Auth::guard('web')->login($check_data);
                    return parent::authenticate();
                } else {
                    Notification::make()
                    ->title('No account found with the provided email address. Please check your credentials and try again.')
                    ->body('')
                    ->danger()
                    ->send();
                    return null;
                }
            } else {
                Notification::make()
                ->title('Authentication Failed')
                ->body('The password you entered is incorrect. Please try again.')
                ->danger()
                ->send();
                return null;
            }
        } else {
            Notification::make()
            ->title('Authentication Failed')
            ->body('No account found with the provided email address. Please check your credentials and try again.')
            ->danger()
            ->send();
            return null;
        }

    }


    public static function canAccess(): bool
    {
       return true;
    }


}

<?php

namespace App\User\Pages\Auth;

use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login;
use App\Models\User;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Parents;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserLogin extends Login
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

        $user = Student::where('email', $email)->first() ?? Staff::where('email', $email)->first() ?? Parents::where('email', $email)->first();

        if (!empty($user)) {
            $check_credential = User::where('id', $user->user_id)->first();

            if (Hash::check($password, $check_credential->password)) {

                if ($user instanceof Student) {
                    $role = 'student';
                } elseif ($user instanceof Staff) {
                    $role = 'staff';
                } elseif ($user instanceof Parents) {
                    $role = 'parent';
                } else {
                    $role = 'null';
                }

                if ($role != 'null') {
                    Auth::guard($role)->login($user);
                    Auth::guard('web')->login($check_credential);
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

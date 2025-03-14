<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StudentloginResource\Pages;
use App\Admin\Resources\StudentloginResource\RelationManagers;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Studentlogin;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StudentloginResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationGroup = 'Student Report';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Student Login Report';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('admission_no')->searchable()->sortable(),
                TextColumn::make('first_name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('Reset Password')
                ->label('Reset Password')
                ->modalHeading('Reset Password')
                ->modalWidth('5xl')
                ->form([
                    Forms\Components\TextInput::make('password')
                        ->label('New Password')
                        ->password()
                        ->required()
                        ->minLength(8) 
                        ->rules(['confirmed']), 
                ])
                ->action(function (array $data, $record) {
                    $user = \App\Models\User::find($record->user_id);
                    if (!$user) {
                        throw new \Exception('Associated user not found.');
                    }
                    $user->update([
                        'password' => bcrypt($data['password']),
                    ]);
                    session()->flash('success', 'Password has been updated successfully.');
                }),
            
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStudentlogins::route('/'),
            'create' => Pages\CreateStudentlogin::route('/create'),
            'edit' => Pages\EditStudentlogin::route('/{record}/edit'),
        ];
    }
}

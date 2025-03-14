<?php

namespace App\Admin\Resources;

use App\Admin\Resources\UnApprovedStudentResource\Pages;
use App\Admin\Resources\UnApprovedStudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UnApprovedStudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Unapproved students';

    protected static ?int $navigationSort = 9;


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
                Tables\Columns\TextColumn::make('index')->label('S.No')
                ->rowIndex(),

                Tables\Columns\TextColumn::make('name')
                ->label('Student Name')
                ->getStateUsing(function ($record) {
                    return $record->first_name . ' ' . $record->last_name;
                })
                ->searchable(['first_name', 'last_name']),

                Tables\Columns\TextColumn::make('current_status')
                ->label('Status')
                ->badge()
                ->getStateUsing(function ($record) {
                    if ($record->status == 2) {
                       return 'Un Approved';
                    } else {}
                })
                ->color(function ($state) {
                    if($state == 'Un Approved'){
                        return 'danger';
                    } else {}
                })
                ->extraAttributes(['style' => 'width: 200px;']),

                SelectColumn::make('status')
                ->label('Action')
                ->options([
                    1 => 'Approved'
                ])
                ->placeholder('Select a status')
                ->afterStateUpdated(function ($state, $record) {
                    Student::where('id', $record->id)->update([
                        'status' => $state,
                    ]);
                    Notification::make()
                        ->title('Student Status Updated')
                        ->success()
                        ->body("The student status has been successfully updated.")
                        ->send();

                })->extraAttributes(['style' => 'width: 200px;'])

            ])
            ->filters([
                //
            ])
            ->emptyState(fn() => new HtmlString('<div style="text-align: center; font-size: 18px; font-weight: bold; color: #888; margin-top: 25px; margin-bottom: 25px;">No records found.</div>'))
            ->actions([])
            ->bulkActions([]);
    }

    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()->where('status', 2);
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
            'index' => Pages\ListUnApprovedStudents::route('/'),
        ];
    }
}

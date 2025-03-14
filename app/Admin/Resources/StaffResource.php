<?php

namespace App\Admin\Resources;

use App\Admin\Resources\StaffResource\Pages;
use App\Admin\Resources\StaffResource\RelationManagers;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StaffResource extends Resource
{
    protected static ?string $model = Staff::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Human Resource';

    protected static ?string $navigationLabel = 'Staff';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('first_name')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),

                Forms\Components\TextInput::make('email')
                ->email()
                ->required(),

                DatePicker::make('dob')
                ->label('Date of Birth')
                ->maxDate(now())
                ->displayFormat('Y-m-d')
                ->required(),

                Forms\Components\TextInput::make('mobile')
                ->label('Mobile Number')
                ->tel()
                ->rules([
                    'required',
                    'regex:/^(\+?\d{1,4}[-\s]?)?\(?\d{3}\)?[-\s]?\d{3}[-\s]?\d{4}$/'
                ])
                ->required(),

                Radio::make('status')
                ->options([
                    '1' => 'Active',
                    '2' => 'Deactive',
                ])->default('1')->required(),

                RichEditor::make('current_address')
                ->label('Address')
                ->required()
                ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('index')->label('S.No')
            ->rowIndex(),

            Tables\Columns\TextColumn::make('name')
            ->label('name')
            ->getStateUsing(function ($record) {
                return $record->first_name . ' ' . $record->last_name;
            })
            ->searchable(['first_name', 'last_name']),

            Tables\Columns\TextColumn::make('email'),

            Tables\Columns\TextColumn::make('status')
            ->label('Status')
            ->badge()
            ->getStateUsing(function ($record) {
                if ($record->status == 1) {
                   return 'Active';
                } else if ($record->status == 2) {
                    return 'Deactive';
                } else {}
            })
            ->color(function ($state) {
                if($state == 'Active'){
                    return 'success';
                } else if ($state == 'Deactive') {
                    return 'danger';
                } else {}
            }),

            Tables\Columns\TextColumn::make('current_address')
                ->label('Address')
                ->getStateUsing(function ($record) {
                    if ($record->current_address != '' && $record->current_address != NULL) {
                        return strip_tags($record->current_address);
                    } else {
                        return '--';
                    }
                }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

            ])
            ->bulkActions([]);
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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
            'view' => Pages\ViewStaff::route('/{record}'),
        ];
    }
}

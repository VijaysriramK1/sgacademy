<?php

namespace App\Admin\Resources;

use App\Admin\Resources\LeadIntegrationResource\Pages;
use App\Admin\Resources\LeadIntegrationResource\RelationManagers;
use App\Models\LeadIntegration;
use App\Models\SourceType;
use App\Models\Staff;
use Filament\Forms;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class LeadIntegrationResource extends Resource
{
    protected static ?string $model = LeadIntegration::class;

    
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Lead Integration';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Lead Integration')
                    ->schema([

                        TextInput::make('source')->label('Source'),
                        Select::make('status')
                            ->options([
                                1 => 'Active',
                                0 => 'Inactive',
                            ])
                            ->default(1)
                            ->searchable()
                            ->preload()
                            ->native(false),
                        MarkdownEditor::make('description')->label('Description')->columnSpanFull(),

                    ])->columns(2),

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->query(SourceType::whereIn('status', [0, 1]))
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('name')
                    ->label('Source')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->formatStateUsing(fn($state) => match ($state) {
                        1 => 'Active',
                        0 => 'Inactive',
                    })
                    ->badge()
                    ->color(fn($state) => match ($state) {
                        1 => 'success',
                        0 => 'danger',
                    })
                    ->searchable(),
                TextColumn::make('share_link')
                    ->label('Link')
                    ->default(fn($record) => url('/lead_integration/' . $record->id))
                    ->copyable(fn($record) => $record->status == 1)
                    ->badge()
                    ->color(fn($record) => $record->status == 1 ? 'success' : 'danger'),

            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        1 => 'Active',
                        0 => 'Inactive',
                    ])
                    ->label('Status')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
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
            'index' => Pages\ListLeadIntegrations::route('/'),
            'create' => Pages\CreateLeadIntegration::route('/create'),
            'edit' => Pages\EditLeadIntegration::route('/{record}/edit'),
        ];
    }
}

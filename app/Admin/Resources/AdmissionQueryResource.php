<?php

namespace App\Admin\Resources;

use App\Admin\Resources\AdmissionQueryResource\Pages;
use App\Admin\Resources\AdmissionQueryResource\RelationManagers;
use App\Models\AdmissionQuery;
use App\Models\Program;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Actions\ActionGroup;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action as ActionsAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class AdmissionQueryResource extends Resource
{
    protected static ?string $model = AdmissionQuery::class;


    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Student Info';

    protected static ?string $navigationLabel = 'Admission Query';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Admission Query')->schema([
                    TextInput::make('name')
                        ->label('Name')
                        ->required()
                        ->suffixIcon('heroicon-o-user'),

                    TextInput::make('phone')
                        ->label('Phone')
                        ->required()
                        ->suffixIcon('heroicon-o-phone'),

                    TextInput::make('email')
                        ->label('Email')
                        ->required()
                        ->email()
                        ->suffixIcon('heroicon-s-envelope'),

                    Textarea::make('address')
                        ->label('Address')
                        ->nullable(),

                    Textarea::make('description')
                        ->label('Description')
                        ->nullable(),

                    DatePicker::make('date')
                        ->label('Date')
                        ->required(),

                    DatePicker::make('follow_up_date')
                        ->label('Follow-up Date')
                        ->required(),

                    DatePicker::make('next_follow_up_date')
                        ->label('Next Follow-up Date')
                        ->nullable(),

                    TextInput::make('assigned')
                        ->label('Assigned')
                        ->required(),

                    TextInput::make('reference')
                        ->label('Reference')
                        ->numeric()
                        ->nullable(),

                    TextInput::make('source')
                        ->label('Source')
                        ->numeric()
                        ->nullable(),

                    TextInput::make('no_of_child')
                        ->label('Number of Children')
                        ->required()
                        ->numeric(),

                    Radio::make('active_status')
                        ->label('Active Status')
                        ->options([
                            true => 'Active',
                            false => 'Inactive',
                        ])
                        ->default(true)
                        ->required(),


                    Select::make('program_id')->relationship('program', 'name')->searchable()->preload()->native(false),



                ])->columns(2),
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('first_name')
                    ->label('Name')
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn($record) => "{$record->first_name} {$record->last_name}")->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('phone')->label('Phone')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('email')->label('Email')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('Source.name')->label('Source')->searchable()->sortable()->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(function ($record) {
                        switch ($record->status) {
                            case 1:
                                return 'Pending';
                            case 2:
                                return 'Converted';
                            default:
                                return 'Unknown';
                        }
                    })
                    ->badge()
                    ->color(function ($record) {
                        return match ($record->status) {
                            1 => 'danger',
                            2 => 'success',
                            default => 'secondary',
                        };
                    })->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('date')->label('Query Date')->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('follow_up_date')->label('Last Follow Up Date')->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('date')->label('Date From'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['date'], fn($query, $date) => $query->whereDate('date', '>=', $date));
                    }),


                Tables\Filters\Filter::make('follow_up_date')
                    ->form([
                        DatePicker::make('follow_up_date')->label('Date To'),
                    ])
                    ->query(function (Builder $query, array $data) {
                        return $query->when($data['follow_up_date'], fn($query, $date) => $query->whereDate('follow_up_date', '<=', $date));
                    }),


                SelectFilter::make('active_status')
                    ->label('Status')
                    ->options([
                        '1' => 'Pending',
                        '2' => 'Converted',
                    ]),


            ], layout: FiltersLayout::AboveContent)
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('View')
                        ->modalHeading('Admission Query')
                        ->extraModalFooterActions([
                            Tables\Actions\EditAction::make(),
                            
                            
                            Tables\Actions\Action::make('paymentOffCanvas')
                            ->icon('heroicon-m-banknotes')
                            ->label('Payment')
                            ->color('success')
                            ->slideOver() // Ensures it's a slide-over modal
                            ->modalHeading('Select Payment Method')
                            ->modalCancelActionLabel('Close')
                            ->modalSubmitAction(false) // Disable the default submit button
                            ->form(function ($record) {
                                return [
                                    Section::make('')
                                        ->schema([
                                            Placeholder::make('online_payment')
                                                ->label('💳 Online Payment')
                                                ->content('Click here to proceed with online payment')
                                                ->extraAttributes([
                                                    'x-data' => '{}',
                                                    'x-on:click' => '$dispatch("open-razorpay")',
                                                ]),
                                        ])
                                        ->extraAttributes([
                                            'class' => 'p-4 cursor-pointer',
                                            'style' => 'border-left: 4px solid #10B981 !important; background-color: #ECFDF5 !important;',
                                        ]),
                            
                                    Section::make('')
                                        ->schema([
                                            Placeholder::make("offline_payment") 
                                                ->label("💵 Offline Payment") 
                                                ->content('Offline payments require cash or bank transfer')
                                              
                                        ])
                                        ->extraAttributes([
                                            'x-data' => '{}',
                                            'x-on:click' => "window.location.href = '" . route('filament.admin.admission-queries.payments.create', ['id' => $record->id]) . "';",
                                            'class' => 'p-4 cursor-pointer',
                                           'style' => 'border-left: 4px solid #10B981 !important; background-color: #ECFDF5 !important;',
                                        ]),
                                ];
                            })
                            
                            ->modalWidth('sm')
                            ->extraAttributes([
                                'x-data' => 'razorpayHandler()', 
                            ])
                        ])
                        ->modalWidth('2xl')
                        ->infolist(
                            fn($record) => Infolist::make()
                                ->record($record)
                                ->schema([
                                    TextEntry::make('first_name')
                                        ->label('Full Name')
                                        ->formatStateUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                                        ->icon('heroicon-m-user')
                                        ->iconColor('primary'),
                                    TextEntry::make('email')
                                        ->label('Email Address')
                                        ->icon('heroicon-m-envelope')
                                        ->iconColor('primary'),
                                    TextEntry::make('phone')
                                        ->label('Phone')
                                        ->icon('heroicon-m-phone')
                                        ->iconColor('primary'),
                                    TextEntry::make('Source.name')
                                        ->label('Source'),
                                    TextEntry::make('status')
                                        ->label('Status')
                                        ->formatStateUsing(function ($record) {
                                            switch ($record->status) {
                                                case 1:
                                                    return 'Pending';
                                                case 2:
                                                    return 'Converted';
                                                default:
                                                    return 'Unknown';
                                            }
                                        })
                                        ->badge()
                                        ->color(function ($record) {
                                            return match ($record->status) {
                                                1 => 'danger',
                                                2 => 'success',
                                                default => 'secondary',
                                            };
                                        }),
                                    TextEntry::make('batch.name')
                                        ->label('Batch')
                                        ->badge(),
                                    TextEntry::make('program.name')
                                        ->label('Program')
                                        ->badge(),
                                    TextEntry::make('program.admissionfees')
                                        ->label('Program Fee')
                                        ->formatStateUsing(function ($state, $record) {
                                            $fee = $record->program->admissionfees()
                                                ->where('batch_id', $record->batch_id)
                                                ->first();

                                            return $fee ? number_format($fee->amount, 2) : 'N/A';
                                        })
                                        ->badge()
                                        ->color('success')
                                        ->icon('heroicon-m-banknotes')
                                        ->iconColor('primary')
                                ])
                                ->columns(2)
                        ),


                    Tables\Actions\DeleteAction::make()
                ])
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
            'index' => Pages\ListAdmissionQueries::route('/'),
            'create' => Pages\CreateAdmissionQuery::route('/create'),
          
        ];
    }
    
   
}

<?php

namespace App\Admin\Resources;

use App\Admin\Resources\ContentResource\Pages;
use App\Admin\Resources\ContentResource\RelationManagers;
use App\Models\BatchPrograms;
use App\Models\Content;
use App\Models\Program;
use App\Models\Section as ModelsSection;
use Faker\Provider\ar_EG\Text;
use Filament\Facades\Filament;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ContentResource extends Resource
{
    protected static ?string $model = Content::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = ' Download Center';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Content List';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Add Content')
                    ->schema([
                        Select::make('content_type_id')
                            ->relationship('contentType', 'name')
                            ->searchable()
                            ->native(false)
                            ->preload(),
                        TextInput::make('youtube_link')
                            ->label('YouTube Link')
                            ->prefix('https://'),
                        FileUpload::make('upload_file')

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        $isSharedTab = request()->query('activeTab') == 'shared';
      
    
        return $table
            ->columns([
              
                TextColumn::make('id')
                    ->label('Sl')
                    ->rowIndex()
                    ->visible(!$isSharedTab),
                TextColumn::make('contentType.name')
                    ->label('Content Type')
                    ->searchable()
                    ->sortable()
                    ->visible(!$isSharedTab),
                TextColumn::make('youtube_link')
                    ->label('YouTube Link')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->listWithLineBreaks()
                    ->visible(!$isSharedTab),
                TextColumn::make('upload_file')
                    ->label('Upload File')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->listWithLineBreaks()
                    ->visible(!$isSharedTab),
    
                
                TextColumn::make('id')
                    ->rowIndex()
                    ->label('Sl')
                    ->visible($isSharedTab),
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->visible($isSharedTab),
                TextColumn::make('send_type')
                    ->label('Share Type')
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'G' => 'Group',
                        'I' => 'Individual',
                        'C' => 'Class',
                        'p' => 'Public',
                        default => $state,
                    })
                    ->badge()
                    ->color(function (string $state) {
                        return match ($state) {
                            'G' => 'primary',
                            'I' => 'success',
                            'C' => 'warning',
                            'p' => 'danger',
                            default => 'secondary',
                        };
                    })
                    ->visible($isSharedTab),
                TextColumn::make('share_date')
                    ->label('Share Date')
                    ->searchable()
                    ->sortable()
                    ->visible($isSharedTab),
                TextColumn::make('valid_upto')
                    ->label('Valid Date')
                    ->searchable()
                    ->sortable()
                    ->visible($isSharedTab),
                TextColumn::make('User.full_name')
                    ->label('Shared By')
                    ->searchable()
                    ->sortable()
                    ->visible($isSharedTab),
                TextColumn::make('description')
                    ->label('Description')
                    ->searchable()
                    ->sortable()
                    ->visible($isSharedTab)
                    ->sortable()->wrap()->listWithLineBreaks(),
            ])    
            ->filters([
                SelectFilter::make('send_type')
                ->options([
                    'G' => 'Group',
                    'I' => 'Individual',
                    'C' => 'Class',
                    'p' => 'Public', 
                ])
                ->label('Status')->visible($isSharedTab)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                    ->requiresConfirmation()
                    ->action(fn(Collection $records) => $records->each->delete())
                    ->color('danger'),
                BulkAction::make('Share Content')
                    ->requiresConfirmation()

                    ->icon('heroicon-s-share')
                    ->modalHeading('Share')
                    ->modalWidth('5xl')
                    ->modalDescription('Choose how you want to share these items.')
                    ->form([
                        Section::make()->schema([
                            Section::make()->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->columnSpanFull(),
                                Section::make()->schema([
                                    DatePicker::make('share_date')
                                        ->required(),
                                    DatePicker::make('valid_upto')
                                        ->required()
                                        ->afterOrEqual('share_date'),
                                ])->columns(2),
                                Textarea::make('description')
                                    ->columnSpanFull(),
                                Section::make('Selected Content')
                                    ->schema(function ($livewire) {
                                        $records = $livewire->getSelectedTableRecords();
                                        return $records->map(function ($record, $index) {
                                            return TextInput::make("content_url_{$record->id}")
                                                ->label("Content " . ($index + 1))
                                                ->default(
                                                    $record->youtube_link ??
                                                        $record->upload_file ??
                                                        ''
                                                )
                                                ->disabled()
                                                ->columnSpanFull();
                                        })->toArray();
                                    })
                            ])->columnSpan(1),
                            Tabs::make('send_type')
                                ->tabs([
                                    Tabs\Tab::make('group')
                                        ->label('Group')
                                        ->schema([
                                            Radio::make('content_ids')
                                                ->label('')
                                                ->options([
                                                    1 => 'Student',
                                                    2 => 'Parents',
                                                    3 => 'Teacher',
                                                    4 => 'Admin',
                                                    5 => 'Accountant',
                                                    6 => 'Receptionist',
                                                    7 => 'Librarian',
                                                    8 => 'Driver',
                                                ])
                                        ]),
                                    Tabs\Tab::make('individual')
                                        ->label('Individual')
                                        ->schema([
                                            Select::make('gr_role_ids')
                                                ->label('Role')
                                                ->options([
                                                    1 => 'Student',
                                                    2 => 'Parents',
                                                    3 => 'Teacher',
                                                    4 => 'Admin',
                                                    5 => 'Accountant',
                                                    6 => 'Receptionist',
                                                    7 => 'Librarian',
                                                    8 => 'Driver',
                                                ])
                                                ->multiple()
                                                ->searchable(),
                                            Select::make('ind_user_ids')
                                                ->label('Name')
                                                ->options(function (callable $get) {
                                                    $roleIds = $get('gr_role_ids');
                                                    if (empty($roleIds)) return [];
                                                })
                                                ->multiple()
                                                ->searchable()
                                                ->reactive()
                                        ]),
                                    Tabs\Tab::make('program_id')
                                        ->label('Program')
                                        ->schema([
                                            Select::make('program_id')
                                                ->label('Program')
                                                ->options(
                                                    Program::query()
                                                        ->pluck('name', 'id')
                                                        ->toArray()
                                                )
                                                ->searchable()
                                                ->reactive(),
                                            Select::make('section_id')
                                                ->label('Section')
                                                ->options(function (callable $get) {
                                                    $programId = $get('program_id');
                                                    if (!$programId) return [];

                                                    $sections = BatchPrograms::query()
                                                        ->where('program_id', $programId)
                                                        ->pluck('section_id');

                                                    return ModelsSection::query()
                                                        ->whereIn('id', $sections)
                                                        ->pluck('name', 'id')
                                                        ->toArray();
                                                })
                                                ->searchable()
                                                ->reactive()
                                        ]),
                                ])->columnSpan(1),
                        ])->columns(2),
                    ])
                    ->action(function (array $data, $records) {
                        $sendType = match (true) {
                            isset($data['group']) => 'G',
                            isset($data['individual']) => 'I',
                            isset($data['program_id']) => 'C',
                            default => null
                        };
                        $contentUrls = collect($records)->map(function ($record) {
                            return $record->youtube_link ?? $record->upload_file ?? '';
                        })->filter()->toArray();
                        try {
                            DB::transaction(function () use ($data, $sendType, $contentUrls) {
                                $user = Auth::User();
                                $institution = DB::table('institutions')->first();
                                DB::table('content_share_lists')->insert([
                                    'title' => $data['title'],
                                    'share_date' => $data['share_date'],
                                    'valid_upto' => $data['valid_upto'],
                                    'description' => $data['description'] ?? null,
                                    'send_type' => $sendType,
                                    'content_ids' => isset($data['content_ids']) ? json_encode([$data['content_ids']]) : null,
                                    'gr_role_ids' => isset($data['gr_role_ids']) ? json_encode($data['gr_role_ids']) : null,
                                    'ind_user_ids' => isset($data['ind_user_ids']) ? json_encode($data['ind_user_ids']) : null,
                                    'program_id' => $data['program_id'] ?? null,
                                    'section_ids' => isset($data['section_id']) ? json_encode([$data['section_id']]) : null,
                                    'url' => json_encode($contentUrls),
                                    'shared_by' => $user->id,
                                    'institution_id' =>  $institution->id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            });
                            Notification::make()
                                ->title('Content shared successfully')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error sharing content')
                                ->danger()
                                ->body($e->getMessage())
                                ->send();
                        }
                    }),
                BulkAction::make('Generate Url')
                    ->requiresConfirmation()
                    ->requiresConfirmation()

                    ->icon('heroicon-o-paper-clip')
                    ->modalHeading('Generate Url')
                    ->modalWidth('5xl')
                    ->modalDescription('Choose how you want to share these items.')
                    ->form([
                        section::make()
                            ->schema([
                                TextInput::make('title')
                                    ->label('Title')
                                    ->required()
                                    ->columnSpanFull(),
                                Section::make()->schema([
                                    DatePicker::make('share_date')
                                        ->required(),
                                    DatePicker::make('valid_upto')
                                        ->required()
                                        ->afterOrEqual('share_date'),
                                ])->columns(2),
                                Textarea::make('description')
                                    ->columnSpanFull(),
                                Section::make()
                                    ->schema(function ($livewire) {
                                        $records = $livewire->getSelectedTableRecords();
                                        return $records->map(function ($record, $index) {
                                            return TextInput::make("content_url_{$record->id}")
                                                ->label("Content " . ($index + 1))
                                                ->default(
                                                    $record->youtube_link ??
                                                        $record->upload_file ??
                                                        ''
                                                )
                                                ->disabled()
                                                ->columnSpanFull();
                                        })->toArray();
                                    })
                            ])->columns(2)
                    ])
                    ->action(function (array $data, $records) {
                        $contentUrls = collect($records)->map(function ($record) {
                            return $record->youtube_link ?? $record->upload_file ?? '';
                        })->filter()->toArray();

                        try {
                            DB::transaction(function () use ($data, $contentUrls) {
                                $user = Auth::User();
                                $institution = DB::table('institutions')->first();
                                DB::table('content_share_lists')->insert([
                                    'title' => $data['title'],
                                    'share_date' => $data['share_date'],
                                    'valid_upto' => $data['valid_upto'],
                                    'description' => $data['description'] ?? null,
                                    'send_type' => "p",
                                    'url' => json_encode($contentUrls),
                                    'shared_by' => $user->id,
                                    'institution_id' =>  $institution->id,
                                    'created_at' => now(),
                                    'updated_at' => now(),
                                ]);
                            });
                            Notification::make()
                                ->title('Content shared successfully')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error sharing content')
                                ->danger()
                                ->body($e->getMessage())
                                ->send();
                        }
                    }),
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
            'index' => Pages\ListContents::route('/'),
            // 'create' => Pages\CreateContent::route('/create'),
            // 'edit' => Pages\EditContent::route('/{record}/edit'),
        ];
    }
}

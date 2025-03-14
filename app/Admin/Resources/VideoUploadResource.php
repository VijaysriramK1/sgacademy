<?php

namespace App\Admin\Resources;

use App\Admin\Resources\VideoUploadResource\Pages;
use App\Admin\Resources\VideoUploadResource\RelationManagers;
use App\Models\BatchPrograms;
use App\Models\Program;
use App\Models\Section;
use App\Models\VideoUpload;
use Filament\Forms;
use Filament\Forms\Components\Section as ComponentsSection;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\HtmlString;

use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Features\SupportConsoleCommands\Commands\MakeCommand;
use Filament\Tables\Columns\CustomColumn;

class VideoUploadResource extends Resource
{
    protected static ?string $model = VideoUpload::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';

    protected static ?string $navigationGroup = ' Download Center';

    protected static ?string $navigationLabel = 'Video List';

    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                ComponentsSection::make('Add Video')
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

                    return Section::query()
                        ->whereIn('id', $sections)
                        ->pluck('name', 'id')
                        ->toArray();
                })
                ->searchable()
                ->reactive(),
                TextInput::make('title')->required(),
                TextInput::make('youtube_link')->label('Video link')->required(),
                Textarea::make('description')->label('Description')->columnSpanFull()
                ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->label('Sl')->rowIndex(),
                TextColumn::make('title')->label('Title')->searchable()->sortable(),
                TextColumn::make('description')->label('Description')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                TextColumn::make('program.name')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                TextColumn::make('section.name')->searchable()->sortable()->wrap()->listWithLineBreaks(),
                TextColumn::make('youtube_link')
                ->label('Play Video')
                ->formatStateUsing(fn($state) => match ($state) {
                    $state  => 'Active',
                    null => 'Inactive',
                })
                ->badge()
                ->color(fn($state) => match ($state) {
                    $state  => 'success',
                    null => 'danger',
                })
                ->searchable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('playVideo')
                ->label('Play')
                ->modalHeading('Watch Video')
                ->modalWidth('5xl')
                ->icon('heroicon-o-play-circle')
                ->modalActions([]) 
                ->modalContent(function ($record) {
                    $videoId = static::getYouTubeVideoId($record->youtube_link);
                    if (!$videoId) {
                        return new HtmlString('<p class="text-red-500">Invalid YouTube URL</p>');
                    }
                    return new HtmlString('
                        <div class="relative" style="padding-top: 56.25%">
                            <iframe 
                                class="absolute top-0 left-0 w-full h-full"
                                src="https://www.youtube.com/embed/' . $videoId . '"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    ');
                })
            
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
            'index' => Pages\ListVideoUploads::route('/'),
            // 'create' => Pages\CreateVideoUpload::route('/create'),
            // 'edit' => Pages\EditVideoUpload::route('/{record}/edit'),
        ];
    }
    public static function getYouTubeVideoId($url)
    {
        // Match YouTube video ID using a regular expression
        if (preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $url, $matches)) {
            return $matches[1]; // Return the video ID
        }

        return null; // Return null if no match is found
    }

}

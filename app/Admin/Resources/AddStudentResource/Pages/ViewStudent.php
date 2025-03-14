<?php

namespace App\Admin\Resources\AddStudentResource\Pages;

use App\Admin\Resources\AddStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;

class ViewStudent extends ViewRecord
{
    protected static string $resource = AddStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Tabs::make('Student Information')
                    ->tabs([
                        Tabs\Tab::make('Profile Overview')
                            ->schema([
                                Section::make('')
                                    ->schema([
                                        ImageEntry::make('student_photo')
                                            ->defaultImageUrl(asset('logo/empty_profile.jpeg'))
                                            ->label('')
                                            ->circular(),
                                        Section::make('About')
                                            ->schema([
                                                TextEntry::make('first_name')
                                                    ->label('')
                                                    ->formatStateUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                                                    ->icon('heroicon-o-user'),
                                                TextEntry::make('email')
                                                    ->label('')
                                                    ->icon('heroicon-o-envelope'),
                                                TextEntry::make('mobile')
                                                    ->label('')
                                                    ->icon('heroicon-o-phone'),

                                            ]),
                                        Section::make('Address')
                                            ->icon('heroicon-o-map-pin')
                                            ->schema([
                                                TextEntry::make('current_address')
                                                    ->label('')
                                                    ->formatStateUsing(function ($state) {
                                                        $parts = array_map('trim', explode(',', $state));
                                                        return implode('<br>', $parts);
                                                    })
                                                    ->html(),
                                            ]),
                                    ])->columnSpan(3),
                                Section::make('')
                                    ->schema([
                                        Section::make('Student Information')
                                            ->schema([
                                                Grid::make(3)
                                                    ->schema([
                                                        TextEntry::make('first_name')
                                                            ->label('Name')
                                                            ->formatStateUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                                                            ->icon('heroicon-o-user'),
                                                        TextEntry::make('email')
                                                            ->label('Email')
                                                            ->icon('heroicon-o-envelope'),
                                                        TextEntry::make('mobile')
                                                            ->label('Number')
                                                            ->icon('heroicon-o-phone'),
                                                        TextEntry::make('admission_no')
                                                            ->label('Admission No')
                                                            ->icon('heroicon-o-identification'),
                                                        TextEntry::make('roll_no')
                                                            ->label('Roll No')
                                                            ->icon('heroicon-o-hashtag'),
                                                        TextEntry::make('admission_date')
                                                            ->label('Admission Date')
                                                            ->date()
                                                            ->icon('heroicon-o-calendar'),
                                                        TextEntry::make('dob')
                                                            ->label('Date Of Birth')
                                                            ->date()
                                                            ->icon('heroicon-o-cake'),
                                                        TextEntry::make('gender')
                                                            ->label('Gender')
                                                            ->formatStateUsing(fn(string $state): string => ucfirst($state))
                                                            ->icon('heroicon-o-user-circle'),
                                                        TextEntry::make('blood_group')
                                                            ->label('Blood Group')
                                                            ->icon('heroicon-o-heart'),
                                                        TextEntry::make('height')
                                                            ->label('Height')
                                                            ->icon('heroicon-o-arrow-trending-up'),
                                                        TextEntry::make('weight')
                                                            ->label('Weight')
                                                            ->icon('heroicon-o-scale'),
                                                        TextEntry::make('')
                                                            ->label(''),
                                                        TextEntry::make('current_address')
                                                            ->label('Current Address')
                                                            ->icon('heroicon-o-map-pin')
                                                            ->html(),
                                                        TextEntry::make('permanent_address')
                                                            ->label('Permanent Address')
                                                            ->icon('heroicon-o-map')
                                                            ->html(),
                                                    ])
                                            ]),
                                        Section::make('Parents Information')
                                            ->schema([
                                                TextEntry::make('relation')
                                                    ->label('Relation'),
                                                RepeatableEntry::make('parents')
                                                    ->schema([
                                                        Grid::make(3)
                                                            ->schema([
                                                                TextEntry::make('first_name')
                                                                    ->label('Name')
                                                                    ->formatStateUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                                                                    ->icon('heroicon-o-user'),
                                                                TextEntry::make('email')
                                                                    ->label('Email')
                                                                    ->icon('heroicon-o-envelope'),
                                                                TextEntry::make('mobile')
                                                                    ->label('Mobile')->icon('heroicon-o-phone'),
                                                                TextEntry::make('gender')
                                                                    ->label('Gender')
                                                                    ->formatStateUsing(fn(string $state): string => ucfirst($state))->icon('heroicon-o-user-circle'),
                                                            ]),
                                                    ]),
                                            ]),
                                        Section::make('Documents')
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        TextEntry::make('document_title_1')
                                                            ->label('Document 1 Title')
                                                            ->url(fn($record) => $record->document_file_1
                                                                ? asset('storage/' . $record->document_file_1)
                                                                : null)
                                                            ->openUrlInNewTab(),
                                                        TextEntry::make('document_title_2')
                                                            ->label('Document 2 Title')
                                                            ->url(fn($record) => $record->document_file_2
                                                                ? asset('storage/' . $record->document_file_2)
                                                                : null)
                                                            ->openUrlInNewTab(),
                                                        TextEntry::make('document_title_3')
                                                            ->label('Document 3 Title')
                                                            ->url(fn($record) => $record->document_file_3
                                                                ? asset('storage/' . $record->document_file_3)
                                                                : null)
                                                            ->openUrlInNewTab(),
                                                        TextEntry::make('document_title_4')
                                                            ->label('Document 4 Title')
                                                            ->url(fn($record) => $record->document_file_4
                                                                ? asset('storage/' . $record->document_file_4)
                                                                : null)
                                                            ->openUrlInNewTab(),
                                                    ])
                                            ]),
                                        // Section::make('Additional Information')
                                        //     ->schema([
                                        //         Grid::make(3)
                                        //             ->schema([
                                        //                 TextEntry::make('custom_field')
                                        //                     ->label('Additional Notes'),
                                        //                 TextEntry::make('custom_field_form_name')
                                        //                     ->label('Custom Field Form Name'),
                                        //                 TextEntry::make('religion')
                                        //                     ->label('Religion'),
                                        //             ]),
                                        //     ])
                                    ])->columnSpan(9),
                            ])->columns(12),

                        Tabs\Tab::make('Program')
                            ->schema([
                                Section::make('')
                                    ->schema([
                                        ImageEntry::make('student_photo')
                                            ->defaultImageUrl(asset('logo/empty_profile.jpeg'))
                                            ->label('')
                                            ->circular(),
                                        Section::make('About')
                                            ->schema([
                                                TextEntry::make('first_name')
                                                    ->label('')
                                                    ->formatStateUsing(fn($record) => "{$record->first_name} {$record->last_name}")
                                                    ->icon('heroicon-o-user'),
                                                TextEntry::make('email')
                                                    ->label('')
                                                    ->icon('heroicon-o-envelope'),
                                                TextEntry::make('mobile')
                                                    ->label('')
                                                    ->icon('heroicon-o-phone'),

                                            ]),
                                        Section::make('Address')
                                            ->icon('heroicon-o-map-pin')
                                            ->schema([
                                                TextEntry::make('current_address')
                                                    ->label('')
                                                    ->formatStateUsing(function ($state) {
                                                        $parts = array_map('trim', explode(',', $state));
                                                        return implode('<br>', $parts);
                                                    })
                                                    ->html(),
                                            ]),
                                    ])->columnSpan(3),
                                Section::make('')
                                    ->schema([
                                        Grid::make(3)
                                            ->schema([
                                                TextEntry::make('enrollment.batchProgram.batch.name')
                                                    ->label('Batch')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),

                                                TextEntry::make('enrollment.batchProgram.program.name')
                                                    ->label('Program'),

                                                TextEntry::make('enrollment.batchProgram.section.name')
                                                    ->label('Section')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),

                                                TextEntry::make('enrollment.batchProgram.semester.name')
                                                    ->label('Semester')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),

                                                TextEntry::make('enrollment.courses.name')
                                                    ->label('Course')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),

                                                TextEntry::make('enrollment.studentCategory.name')
                                                    ->label('Student Category')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),

                                                TextEntry::make('enrollment.studentGroup.name')
                                                    ->label('Student Group')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),
                                                TextEntry::make('enrollment.enrolled_at')
                                                    ->label('Enrolled At')
                                                    ->date(),
                                            ]),
                                    ])->columnSpan(9)
                            ])->columns(12),
                          

                        Tabs\Tab::make('Attendance')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        
                                    ]),
                            ]),

                        Tabs\Tab::make('Mark')
                            ->schema([
                                Grid::make(2)
                                    ->schema([]),
                            ]),
                    ])->columnSpanFull()

            ]);
    }
}

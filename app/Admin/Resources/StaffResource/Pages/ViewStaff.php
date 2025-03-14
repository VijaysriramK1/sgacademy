<?php

namespace App\Admin\Resources\StaffResource\Pages;

use App\Admin\Resources\StaffResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;

class ViewStaff extends ViewRecord
{
    protected static string $resource = StaffResource::class;
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
                                        ImageEntry::make('staff_photo')
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
                                        Section::make('Staff Information')
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
                                                        TextEntry::make('staff_no')
                                                            ->label('Staff No')
                                                            ->icon('heroicon-o-identification'),
                                                        TextEntry::make('roll_no')
                                                            ->label('Roll No')
                                                            ->icon('heroicon-o-hashtag'),
                                                        TextEntry::make('join_date')
                                                            ->label('Join Date')
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
                                                        TextEntry::make('emergency_mobile')
                                                            ->label('Emergency Mobile'),
                                                        TextEntry::make('marital_status')
                                                            ->label('Marital Status'),
                                                        TextEntry::make('fathers_name')
                                                            ->label('Fathers Name'),
                                                        TextEntry::make('mothers_name')
                                                            ->label('Mothers Name'),

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
                                        Section::make('')
                                            ->schema([
                                                Section::make('Bank Information')
                                                    ->schema([
                                                        Grid::make(3)
                                                            ->schema([
                                                                TextEntry::make('bank_account_name')
                                                                    ->label('Account Name'),
                                                                TextEntry::make('bank_account_no')
                                                                    ->label('Account Number')
                                                                    ->icon('heroicon-o-envelope'),
                                                                TextEntry::make('bank_name')
                                                                    ->label('Bank Name')
                                                                    ->icon('heroicon-o-phone'),
                                                                TextEntry::make('bank_brach')
                                                                    ->label('Bank Brach')
                                                                    ->icon('heroicon-o-identification'),
                                                                TextEntry::make('ifsc_code')
                                                                    ->label('Ifsc Code')
                                                                    ->icon('heroicon-o-hashtag'),
                                                            ])
                                                    ]),
                                            ]),
                                        Section::make('')
                                            ->schema([
                                                Section::make('Qualification Information')
                                                    ->schema([
                                                        Grid::make(3)
                                                            ->schema([
                                                                TextEntry::make('qualification')
                                                                    ->label('Qualification'),
                                                                TextEntry::make('experience')
                                                                    ->label('Experience'),
                                                                TextEntry::make('epf_no')
                                                                    ->label('Epf No'),
                                                                TextEntry::make('basic_salary')
                                                                    ->label('Salary'),
                                                                TextEntry::make('contract_type')
                                                                    ->label('Contract Type'),
                                                                TextEntry::make('location')
                                                                    ->label('location'),

                                                            ])
                                                    ]),
                                            ]),
                                        Section::make('')
                                            ->schema([
                                                Section::make('Social Media Information')
                                                    ->schema([
                                                        Grid::make(3)
                                                            ->schema([
                                                                TextEntry::make('facebook_url')
                                                                    ->label('Facebook'),
                                                                TextEntry::make('twiteer_url')
                                                                    ->label('Twiteer'),
                                                                TextEntry::make('linkedin_url')
                                                                    ->label('linked in'),
                                                                TextEntry::make('instragram_url')
                                                                    ->label('Instragram'),
                                                            ])
                                                    ]),
                                            ])
                                    ])->columnSpan(9),
                            ])->columns(12),

                        Tabs\Tab::make('Assign Routine')
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
                                                TextEntry::make('routine.course.name')
                                                    ->label('Cource')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),

                                                TextEntry::make('routine.lesson.title')
                                                    ->label('Lesson'),

                                                TextEntry::make('routine.topic.title')
                                                    ->label('Topic')
                                                    ->formatStateUsing(fn($state) => $state ?? 'N/A'),
                                                TextEntry::make('routine.start_date')
                                                    ->label('Start Date & Time')
                                                    ->formatStateUsing(function ($state, $record) {
                                                        $routine = $record->routine->first();

                                                        if (!$routine) {
                                                            return '<span style="color: gray;">N/A (N/A)</span>';
                                                        }

                                                        $startDate = $routine->start_date ?? 'N/A';
                                                        $startTime = $routine->start_time ?? null;

                                                        if ($startTime && strtotime($startTime)) {
                                                            $startTimeFormatted = date('h:i A', strtotime($startTime));
                                                            $startDateTime = strtotime("{$startDate} {$startTime}");
                                                        } else {
                                                            $startTimeFormatted = 'N/A';
                                                            $startDateTime = null;
                                                        }

                                                        $currentTimestamp = now()->timestamp;

                                                        $color = 'gray';
                                                        if ($startDateTime) {
                                                            if ($currentTimestamp < $startDateTime) {
                                                                $color = 'blue';
                                                            } elseif ($currentTimestamp >= $startDateTime) {
                                                                $color = 'green';
                                                            }
                                                        }
                                                        return "<span class='live-time' data-time='{$startDateTime}' data-type='start' style='color: {$color};'>{$startDate} ({$startTimeFormatted})</span>";
                                                    })
                                                    ->html()
                                                    ->badge(),

                                                TextEntry::make('routine.end_date')
                                                    ->label('End Date & Time')
                                                    ->formatStateUsing(function ($state, $record) {
                                                        $routine = $record->routine->first();

                                                        if (!$routine) {
                                                            return '<span style="color: gray;">N/A (N/A)</span>';
                                                        }

                                                        $endDate = $routine->end_date ?? 'N/A';
                                                        $endTime = $routine->end_time ?? null;

                                                        if ($endTime && strtotime($endTime)) {
                                                            $endTimeFormatted = date('h:i A', strtotime($endTime));
                                                            $endDateTime = strtotime("{$endDate} {$endTime}");
                                                        } else {
                                                            $endTimeFormatted = 'N/A';
                                                            $endDateTime = null;
                                                        }

                                                        $currentTimestamp = now()->timestamp;

                                                        $color = 'gray';
                                                        if ($endDateTime) {
                                                            if ($currentTimestamp < $endDateTime) {
                                                                $color = 'blue'; 
                                                            } elseif ($currentTimestamp >= $endDateTime) {
                                                                $color = 'red'; 
                                                            }
                                                        }

                                                        return "<span class='live-time' data-time='{$endDateTime}' data-type='end' style='color: {$color};'>{$endDate} ({$endTimeFormatted})</span>";
                                                    })
                                                    ->html()
                                                    ->badge(),

                                                TextEntry::make('routine.day')
                                                    ->label('Day')
                                                    ->formatStateUsing(function ($state, $record) {
                                                        $routine = $record->routine->first();

                                                        if (!$routine || !is_array($routine->day)) {
                                                            return '<span style="color: gray;">N/A</span>';
                                                        }

                                                        $orderedDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

                                                        $currentDay = now()->format('l');

                                                        $days = array_intersect($orderedDays, $routine->day);

                                                        $formattedDays = array_map(function ($day) use ($currentDay) {
                                                            return ($day === $currentDay) ? "<span style='color: red; font-weight: bold;'>$day</span>" : $day;
                                                        }, $days);

                                                        return '<ol">' . implode('', array_map(fn($day) => "<li>$day</li>", $formattedDays)) . '</ol>';
                                                    })
                                                    ->html()
                                                    ->badge(),

                                            ]),
                                    ])->columnSpan(9)
                            ])->columns(12),


                        Tabs\Tab::make('Attendance')
                            ->schema([
                                Grid::make(2)
                                    ->schema([]),
                            ]),

                        Tabs\Tab::make('Staff Report')
                            ->schema([
                                Grid::make(2)
                                    ->schema([]),
                            ]),
                    ])->columnSpanFull()

            ]);
    }
}

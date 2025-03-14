<?php

namespace App\User\Resources;

use App\User\Resources\ApplyLeavesResource\Pages;
use App\User\Resources\ApplyLeavesResource\RelationManagers;
use App\Models\Leave;
use App\Models\LeaveType;
use Filament\Forms;
use Filament\Forms\Form;
use App\Helpers\UserHelper;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Set;
use Filament\Forms\Get;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ApplyLeavesResource extends Resource
{
    protected static ?string $model = Leave::class;

    protected static ?string $navigationIcon = 'heroicon-o-clock';

    protected static ?string $navigationGroup = 'Leave';

    protected static ?string $navigationLabel = 'Apply Leave';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Apply Leave')
                ->schema([
                Forms\Components\Select::make('leave_type_id')
                ->options(function () {
                    return \App\Models\LeaveType::all()->pluck('name', 'id');
                })
                ->live()
                ->reactive()
                ->label('Leave Type')
                ->required(),

                Select::make('type_id')
                ->label('Leave Details')
                ->options([
                    1 => 'Full Day',
                    2 => 'Half Day',
                ])
                ->required()
                ->default(1)
                ->reactive(),

                DatePicker::make('start_date')
                ->label('Start Date')
                ->displayFormat('d-m-Y')
                ->required(),

                DatePicker::make('end_date')
                ->label('End date')
                ->displayFormat('d-m-Y')
                ->required(),
                ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function canAccess(): bool
    {
        $role = UserHelper::currentRole();

        if ($role == 'student' || $role == 'staff') {
            $get_permissions = UserHelper::currentRolePermissionDetails();

            if (in_array('apply-leaves', $get_permissions)) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }

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
            'index' => Pages\CreateApplyLeaves::route('/'),
        ];
    }
}

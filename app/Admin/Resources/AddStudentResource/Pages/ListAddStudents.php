<?php

namespace App\Admin\Resources\AddStudentResource\Pages;

use App\Admin\Resources\AddStudentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Models\Student;
use App\Models\User;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Support\Facades\DB;
use App\Models\Studentparents;

class ListAddStudents extends ListRecords
{
    protected static string $resource = AddStudentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->icon('heroicon-m-plus')->label('Add'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            DeleteAction::make()
                ->requiresConfirmation()
                ->before(function (Student $record) {
                    return DB::transaction(function () use ($record) {
                        Studentparents::where('student_id', $record->id)->delete();
                        Studentparents::where('user_id', $record->user_id)->delete();
                        User::where('id', $record->user_id)->delete();
                        return true;
                    });
                })
              
        ];
    }
}

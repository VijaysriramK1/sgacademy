<?php
namespace App\Admin\Resources\AdmissionQueryResource\Pages;

use App\Admin\Resources\AdmissionQueryResource;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Section;
use Filament\Resources\Pages\CreateRecord;
use App\Models\Payment;

class PaymentCreateRecord extends CreateRecord
{
    protected static string $resource = AdmissionQueryResource::class;

    

    // Define your form schema here
    protected function getFormSchema(): array
    {
        return [
            Section::make('Payment Details')
                ->schema([
                    TextInput::make('amount')
                        ->label('Amount')
                        ->numeric()
                        ->required(),

                    Select::make('payment_method')
                        ->label('Payment Method')
                        ->options([
                            'cash' => 'Cash',
                            'bank_transfer' => 'Bank Transfer',
                        ])
                        ->required(),

                    DatePicker::make('payment_date')
                        ->label('Payment Date')
                        ->required()
                        ->maxDate(now()),

                    Textarea::make('notes')
                        ->label('Notes')
                        ->nullable(),
                ])
                ->extraAttributes([
                    'class' => 'p-4 cursor-pointer',
                    'style' => 'border-left: 4px solid #10B981 !important; background-color: #ECFDF5 !important;',
                ]),
        ];
    }
}

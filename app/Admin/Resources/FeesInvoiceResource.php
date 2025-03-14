<?php

namespace App\Admin\Resources;

use App\Admin\Resources\FeesInvoiceResource\Pages;
use Filament\Tables\Actions\ActionGroup;
use App\Models\FeesInvoice;
use App\Models\AdmissionFee;
use App\Models\AdmissionFees;
use App\Models\AdmissionQuery;
use App\Models\FeesType;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FeesInvoiceResource extends Resource
{
    protected static ?string $model = FeesInvoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static ?string $navigationGroup = 'Fees';

    public static ?string $navigationLabel = 'Fees Invoice';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Fees Invoice')
                    ->schema([
                        TextInput::make('invoice_id')
                            ->label('Invoice Name')->required(),

                        Select::make('fee_type_id')
                            ->relationship('feestype', 'type')
                            ->label('Fees Type')
                            ->searchable()
                            ->preload()
                            ->native(true)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                if (!$state) {
                                    $set('name', '');
                                    return;
                                }

                                $feeType = FeesType::find($state);
                                if ($feeType) {
                                    $set('name', $feeType->name);

                                    if ($feeType->type === 'admission') {
                                        $admissionFee = AdmissionFees::where('fee_type_id', $state)->first();
                                        if ($admissionFee) {
                                            $set('program_id', $admissionFee->program_id);
                                            $set('batch_id', $admissionFee->batch_id);
                                            $set('amount', $admissionFee->amount);
                                            $set('paid_amount', $admissionFee->amount);
                                            $set('sub_total', $admissionFee->amount);
                                        }
                                    }
                                }
                            }),

                        Select::make('program_id')
                            ->label('Program')
                            ->relationship('program', 'name')
                            ->searchable()
                            ->preload()
                            ->native(true)
                            ->disabled(
                                fn(Get $get): bool =>
                                FeesType::find($get('fee_type_id'))?->type === 'admission'
                            ),

                        Select::make('batch_id')
                            ->label('Batch')
                            ->relationship('batch', 'name')
                            ->searchable()
                            ->preload()
                            ->native(true)
                            ->disabled(
                                fn(Get $get): bool =>
                                FeesType::find($get('fee_type_id'))?->type === 'admission'
                            ),

                        Select::make('student_id')
                            ->label('Student')
                            ->options(function (Get $get) {
                                $feeType = FeesType::find($get('fee_type_id'));

                                if ($feeType?->type === 'admission') {
                                    return AdmissionQuery::query()
                                        ->get()
                                        ->mapWithKeys(function ($query) {
                                            return [
                                                $query->id => "{$query->first_name} {$query->last_name}"
                                            ];
                                        })
                                        ->toArray();
                                }

                                return Student::query()
                                    ->get()
                                    ->mapWithKeys(function ($student) {
                                        return [
                                            $student->id => "{$student->first_name} {$student->last_name}"
                                        ];
                                    })
                                    ->toArray();
                            })
                            ->searchable()
                            ->preload()
                            ->native(true)
                            ->live(),
                        DatePicker::make('create_date')->label('Create Date'),
                        DatePicker::make('due_date')->label('Due Date'),
                        // Select::make('payment_status')->options([
                        //     'paid' => 'Paid',
                        //     'unpaid' => 'Unpaid',
                        //     'pending' => 'Pending'
                        // ])->label('Payment Status')
                        //     ->searchable()
                        //     ->preload()
                        //     ->native(true),
                        // Select::make('payment_method')
                        //     ->label('Payment Method')
                        //     ->options([
                        //         'cash' => 'Cash',
                        //         'credit_card' => 'Credit Card',
                        //         'bank_transfer' => 'Bank Transfer',
                        //         'online_payment' => 'Online Payment',
                        //     ])
                        //     ->searchable()
                        //     ->preload()
                        //     ->native(true),
                        // TextInput::make('bank_id')->label('Bank')->numeric(),
                        Select::make('type')
                            ->label('Type')
                            ->options([
                                'full' => 'Full',
                                'partial' => 'Partial',
                                'no_pay' => 'No Pay',
                            ])
                            ->default('no_pay')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                if ($state === 'full') {
                                    $set('paid_amount', $get('sub_total')); // Set paid amount to total
                                } elseif ($state === 'no_pay') {
                                    $set('paid_amount', 0); // Set paid amount to zero
                                }
                            }),


                        Select::make('status')
                            ->label('Status')
                            ->options([
                                1 => 'Active',
                                0 => 'Inactive',
                            ])
                            ->default(1)
                            ->searchable()
                            ->preload()
                            ->native(false),

                    ])->columns(2),
                Section::make('Fees Invoice Amount')
                    ->schema([
                        TextInput::make('name')
                            ->label('Fees Types Name')
                            ->disabled()
                            ->afterStateHydrated(function (Get $get, Set $set) {
                                $feeTypeId = $get('fee_type_id');

                                if (is_string($feeTypeId) || is_numeric($feeTypeId)) {
                                    $feeType = FeesType::find($feeTypeId);
                                    if ($feeType) {
                                        $set('name', $feeType->name);
                                    }
                                }
                            })
                            ->reactive()
                            ->dehydrated(false),
                        TextInput::make('amount')
                            ->label('Amount')
                            ->disabled(
                                fn(Get $get): bool =>
                                FeesType::find($get('fee_type_id'))?->type === 'admission'
                            )
                            ->required(
                                fn(Get $get): bool =>
                                in_array($get('type'), ['full', 'partial'])
                            )
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $fine = $get('fine') ?? 0;
                                $discount = $get('discount') ?? 0;
                                $paidAmount = $get('paid_amount') ?? 0;

                                $subTotal = ($state + $fine) - $discount - $paidAmount;
                                $set('sub_total', $subTotal);
                            }),

                        TextInput::make('fine')
                            ->label('Fine')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $amount = $get('amount') ?? 0;
                                $discount = $get('discount') ?? 0;
                                $paidAmount = $get('paid_amount') ?? 0;

                                $subTotal = ($amount + $state) - $discount - $paidAmount;
                                $set('sub_total', $subTotal);
                            }),

                        TextInput::make('discount')
                            ->label('Discount')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $amount = $get('amount') ?? 0;
                                $fine = $get('fine') ?? 0;
                                $paidAmount = $get('paid_amount') ?? 0;

                                $subTotal = ($amount + $fine) - $state - $paidAmount;
                                $set('sub_total', $subTotal);
                            }),

                        TextInput::make('paid_amount')
                            ->label('Paid Amount')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                $amount = $get('amount') ?? 0;
                                $fine = $get('fine') ?? 0;
                                $discount = $get('discount') ?? 0;

                                $subTotal = ($amount + $fine) - $discount - $state;
                                $set('sub_total', $subTotal);
                            }),

                        TextInput::make('sub_total')
                            ->label('Sub Total')
                            ->numeric()
                            ->disabled(),


                    ])
                    ->columns(6)
                    ->visible(
                        fn(Get $get): bool =>
                        in_array($get('type'), ['full', 'partial'])
                    )

            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->rowIndex()
                    ->label('Sl')
                    ->searchable(),
                Tables\Columns\TextColumn::make('student.first_name')
                    ->label('Student')
                    ->searchable(),
                TextColumn::make('feesinvoice.amount')
                    ->label('Amount')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state === null ? '' : $state),

                TextColumn::make('feesinvoice.discount')
                    ->label('Discount')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state === null ? '' : $state),

                TextColumn::make('feesinvoice.fine')
                    ->label('Fine')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => ($state === null || $state === '') ? '0' : $state),


                TextColumn::make('feesinvoice.paid_amount')
                    ->label('Paid')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state === null ? '' : $state),

                TextColumn::make('feesinvoice.due_amount')
                    ->label('Balance')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => $state === null ? '' : $state),



                TextColumn::make('overall_status')->label('Status')
                    ->color(fn($record) => match ($record->overall_status) {
                        'Paid' => 'success',
                        'Partial' => 'warning',
                        'Unpaid' => 'danger',
                    })
                    ->badge()
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('View Invoice')
                        ->label(_("View"))
                        ->url(fn($record) => self::getUrl("invoice", ['record' => $record->id]))
                        ->icon('heroicon-o-document'),
                    Tables\Actions\Action::make('Payment Fees')
                        ->label(_("Payment"))
                        ->url(fn($record) => self::getUrl("payment", ['record' => $record->id]))
                        ->icon('heroicon-o-currency-rupee')
                        ->visible(fn($record) => $record->overall_status !== 'Paid'),

                    Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListFeesInvoices::route('/'),
            'create' => Pages\CreateFeesInvoice::route('/create'),
            'edit' => Pages\EditFeesInvoice::route('/{record}/edit'),
            "invoice" => Pages\Invoice::route('/{record}/invoice'),
            "payment" => Pages\AddPayment::route('/{record}/payment')
        ];
    }
}

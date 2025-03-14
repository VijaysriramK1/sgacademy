<?php

namespace App\Admin\Resources\FeesInvoiceResource\Pages;

use App\Admin\Resources\FeesInvoiceResource;
use App\Models\FeesInvoice;
use App\Models\FeesInvoiceItem;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateFeesInvoice extends CreateRecord
{


    protected static string $resource = FeesInvoiceResource::class;

    protected function handleRecordCreation(array $data): FeesInvoice {         
        return DB::transaction(function () use ($data) {             
            $institution = DB::table('institutions')->first(); 
            
            // Create Fees Invoice
            $feesinvoice = FeesInvoice::create([
                'invoice_id' => $data['invoice_id'],
                'fee_type_id' => $data['fee_type_id'] ?? null,
                'program_id' => $data['program_id'] ?? null,
                'batch_id' => $data['batch_id'] ?? null,
                'student_id' => $data['student_id'] ?? null,
                'create_date' => $data['create_date'] ?? null,
                'due_date' => $data['due_date'] ?? null,
                'payment_method' => $data['payment_method'] ?? null,
                'bank_id' => $data['bank_id'] ?? null,
                'type' => $data['type'] ?? null,
                'status' => $data['status'] ?? null,
                'institution_id' => $institution->id,
            ]);               
            
            // Ensure Correct Values
            $amount = $data['amount'] ?? 0;
            $fine = $data['fine'] ?? 0;
            $discount = $data['discount'] ?? 0;
            $paidAmount = $data['paid_amount'] ?? 0;
            $scholarship = $data['scholarship_amount'] ?? 0;
            $serviceCharge = $data['service_charge'] ?? 0;
    
            // ✅ Correct Subtotal Calculation
            $subtotal = ($amount + $fine) - ($discount + $paidAmount);
    
            // ✅ Correct Due Amount Calculation
            $dueAmount = ($subtotal + $serviceCharge) - $scholarship;
    
            // ✅ Determine Payment Status
            $paymentStatus = $dueAmount <= 0 ? 'Paid' : ($paidAmount > 0 ? 'Partial' : 'Unpaid');
    
            // Create Fees Invoice Item
            $feesinvoiceitems = FeesInvoiceItem::create([
                'fee_invoice_id' => $feesinvoice->id,
                'amount' => $amount,
                'discount' => $discount,
                'fine' => $fine,
                'sub_total' => $subtotal, // ✅ Updated Calculation
                'paid_amount' => $paidAmount,
                'scholarship_amount' => $scholarship,
                'service_charge' => $serviceCharge,
                'due_amount' => $dueAmount, 
                'total' => $amount,
                'note' => $data['note'] ?? null,
            ]);
    
            // Update Fees Invoice with Payment Status
            $feesinvoice->update([
                'payment_status' => $paymentStatus
            ]);
    
            return $feesinvoice;
        });     
    }
    

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}

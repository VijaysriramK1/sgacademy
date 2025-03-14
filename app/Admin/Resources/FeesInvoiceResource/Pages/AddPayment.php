<?php

namespace App\Admin\Resources\FeesInvoiceResource\Pages;

use App\Admin\Resources\FeesInvoiceResource;
use App\Models\FeesInvoice;
use App\Models\FeesInvoiceItem;
use App\Models\FeesPayment;
use App\Models\FeesPaymentDetail;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AddPayment extends Page
{
    protected static string $resource = FeesInvoiceResource::class;

    public $record;
    public $payment;

    public function mount($record)
    {
        $this->record = $record;
        $this->payment = FeesInvoice::with(['student', 'batch', 'program', 'feestype', 'feesinvoice'])->find($record);
    }

    protected static string $view = 'admin.resources.fees-invoice-resource.pages.add-payment';

    public function processPayment(Request $request, $record)
    {
        $invoiceId = $record;


        $invoice = FeesInvoice::findOrFail($invoiceId);
        $paidAmount = $request['paid_amount'];
        $discount = $request['discount'] ?? 0;
        $fine = $request['fine'] ?? 0;
        $due_amount = $request['due_amount'] ?? 0;

        DB::beginTransaction();
        try {

            $invoiceamount = FeesInvoiceItem::where('fee_invoice_id', $invoice->id)->sum('paid_amount');
            $invoicediscount = FeesInvoiceItem::where('fee_invoice_id', $invoice->id)->sum('discount');
            $invoicefine = FeesInvoiceItem::where('fee_invoice_id', $invoice->id)->sum('fine');


            $invoiceitem = FeesInvoiceItem::where('fee_invoice_id', $invoice->id)->first();

            if ($invoiceitem) {
                $newPaidAmount = $invoiceamount + $paidAmount;
                $newDiscount = $invoicediscount + $discount;
                $newFine = $invoicefine + $fine;


                $dueAmount = ($invoiceitem->sub_total + $invoiceitem->fine) - ($newPaidAmount + $newDiscount);


                $invoiceitem->update([
                    'paid_amount' => $newPaidAmount,
                    'discount' => $newDiscount,
                    'fine' => $newFine,
                    'due_amount' => $dueAmount,
                ]);
            }


            $invoice->update([
                'payment_method' => $request['payment_method'],
                'payment_status' => ($dueAmount <= 0) ? 'paid' : 'partial',
                'bank_id' => $request['bank_id'] ?? null,
            ]);

            DB::commit();


            Notification::make()
                ->title('Payment successfully recorded')
                ->success()
                ->send();

            return redirect(FeesInvoiceResource::getUrl('index'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Payment processing failed: ' . $e->getMessage()]);
        }
    }
}

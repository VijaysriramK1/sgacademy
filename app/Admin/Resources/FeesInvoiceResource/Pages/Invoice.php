<?php

namespace App\Admin\Resources\FeesInvoiceResource\Pages;

use App\Admin\Resources\FeesInvoiceResource;
use App\Models\FeesInvoice;
use Filament\Resources\Pages\Page;

class Invoice extends Page
{
    protected static string $resource = FeesInvoiceResource::class;

    public $record;
    public $invoice;
    public function mount($record)
    {
        $this->invoice = FeesInvoice::find($record);
    }


    protected static string $view = 'admin.resources.fees-invoice-resource.pages.invoice';
}

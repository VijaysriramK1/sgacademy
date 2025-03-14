<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeesInvoiceItem extends Model
{
    protected $table = 'fee_invoice_items';

    protected $fillable = [
        'fee_invoice_id', 'amount', 'discount', 'fine', 'sub_total', 'paid_amount', 
        'scholarship_amount', 'service_charge', 'due_amount', 'total', 'note'
    ];

    /**
     * Relationship with FeeInvoice
     */
    public function feeInvoice()
    {
        return $this->belongsTo(FeesInvoice::class, 'fee_invoice_id');
    }

    public function getStatusAttribute()
    {
        // Calculate the effective paid amount (including discount)
        $effectivePaid = $this->paid_amount + $this->discount;
    
        if ($effectivePaid >= $this->amount) {
            return 'Paid';
        } elseif ($effectivePaid > 0 && $effectivePaid < $this->amount) {
            return 'Partial';
        } else {
            return 'Unpaid';
        }
    }
    
  
}

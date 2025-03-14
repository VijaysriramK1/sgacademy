<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeesInvoice extends Model
{
    protected $table = 'fee_invoices';

    protected $fillable = [
        'invoice_id', 'fee_type_id', 'program_id', 'batch_id', 'student_id', 
        'enrollment_id', 'create_date', 'due_date', 'payment_status', 
        'payment_method', 'bank_id', 'type', 'status', 'institution_id'
    ];

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function feestype(): BelongsTo
    {
        return $this->belongsTo(FeesType::class, 'fee_type_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function feesinvoice(): HasMany
    {
        return $this->hasMany(FeesInvoiceItem::class, 'fee_invoice_id');
    }

    /**
     * Get Overall Invoice Status
     */
    public function getOverallStatusAttribute(): string
    {
        $statuses = $this->feesinvoice->pluck('status')->unique();

        if ($statuses->contains('Partial')) {
            return 'Partial';
        } elseif ($statuses->contains('Unpaid')) {
            return 'Unpaid';
        }

        return 'Paid';
    }
}

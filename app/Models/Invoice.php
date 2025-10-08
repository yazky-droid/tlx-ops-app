<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'shipment_id',
        'client_id',
        'issue_date',
        'due_date',
        'total_amount',
        'status',
        'created_by'
    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            // generate invoice number
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = self::generateUniqueInvoiceNumber();
            }
            
            if (Auth::check() && empty($invoice->created_by)) {
                $invoice->created_by = Auth::id();
            }
        });
    }

    private static function generateUniqueInvoiceNumber()
    {
        // Contoh Format: INV/ThnBln/0001
        $prefix = 'INV/' . now()->format('Ym'); 

        $lastInvoice = self::where('invoice_number', 'like', $prefix . '/%')
                           ->latest('id')
                           ->first();
        // cek last number invoice kalau ada untuk di increment
        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->invoice_number, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . '/' . $newNumber;
    }


    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    // billed to the client
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

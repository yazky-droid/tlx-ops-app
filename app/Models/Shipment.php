<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Shipment extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'reference_no',
        'shipper_id',
        'consignee_id',
        'service_type',
        'destination_port',
        'cargo_description',
        'weight_kg',
        'volume_cbm',
        'goods_value',
        'cargo_condition',
        'etd',
        'eta',
        'current_status',
        'user_id'
    ];

    public function shipper()
    {
        return $this->belongsTo(Client::class, 'shipper_id');
    }

     public function consignee()
    {
        return $this->belongsTo(Client::class, 'consignee_id');
    }

    public function trackingLogs()
    {
        return $this->hasMany(ShipmentTracking::class, 'shipment_id');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'shipment_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($shipment) {
            // generate unik reference_no
            if (empty($shipment->reference_no) || $shipment->reference_no == '(Auto-Generated)') {
                $shipment->reference_no = self::generateUniqueReferenceNo();
            }
            
            // set nilai user_id dengan id user yang login 
            if (Auth::check() && empty($shipment->user_id)) {
                $shipment->user_id = Auth::id();
            }
        });
    }

    private static function generateUniqueReferenceNo()
    {
        // Format: TLX-[TAHUN][BULAN]-[NOMOR URUT 4 DIGIT]
        $prefix = 'TLX-' . now()->format('Ym'); 

        // get latest no reference
        $lastShipment = Shipment::where('reference_no', 'like', $prefix . '-%')
                           ->latest('id')
                           ->first();

        // cek nomor last shipment untuk dijumlahkan biar beda
        if ($lastShipment) {            
            $lastNumber = (int) substr($lastShipment->reference_no, -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            
            $newNumber = '0001';
        }

        return $prefix . '-' . $newNumber;
    }


}

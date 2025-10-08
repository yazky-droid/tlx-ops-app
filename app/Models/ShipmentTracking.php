<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ShipmentTracking extends Model
{
    use HasFactory;

    protected $table = 'shipment_tracking';

    protected $fillable = [
        'shipment_id',
        'status_name',
        'location',
        'notes',
        'updated_by',
        'tracking_timestamp',
    ];

    protected static function boot()
    {
        parent::boot();
        
        // ketika create dan update data shipment tracking dia akan mengisi nilainya updated_by dengan id user yang login
        static::creating(function ($trackingLogs) {
            
            if (Auth::check() && empty($trackingLogs->updated_by)) {
                $trackingLogs->updated_by = Auth::id();
            }
        });

        static::updating(function ($trackingLogs) {
            
            if (Auth::check() && empty($trackingLogs->updated_by)) {
                $trackingLogs->updated_by = Auth::id();
            }
        });
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

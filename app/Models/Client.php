<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'is_shipper',
        'is_consignee'
    ];

    public function shipmentsAsShipper()
    {
        return $this->hasMany(Shipment::class, 'shipper_id');
    }

    public function shipmentsAsConsignee()
    {
        return $this->hasMany(Shipment::class, 'consignee_id');
    }
    
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'client_id');
    }
}

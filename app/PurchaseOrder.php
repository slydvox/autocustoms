<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    public function poReferences()
    {
        return $this->hasMany('App\PoReference');
    }

    public function poSacs()
    {
        return $this->hasMany('App\PoSac');
    }

    public function vendorAddress()
    {
        return $this->belongsTo('App\Address', 'vendor_id');
    }

    public function shipAddress()
    {
        return $this->belongsTo('App\Address', 'ship_to_id');
    }

    public function billAddress()
    {
        return $this->belongsTo('App\Address', 'bill_to_id');
    }

    public function soldAddress()
    {
        return $this->belongsTo('App\Address', 'sold_to_id');
    }

}

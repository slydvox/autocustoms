<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoSac extends Model
{
    public function purchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder');
    }
}

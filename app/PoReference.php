<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PoReference extends Model
{
    public function purchaseOrder()
    {
        return $this->belongsTo('App\PurchaseOrder');
    }
}

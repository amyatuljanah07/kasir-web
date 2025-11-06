<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model {
  protected $fillable = [
    'user_id',
    'cashier_id',
    'customer_name',
    'total',
    'discount',
    'payment_method',
    'paid_amount',
    'change',
    'barcode'
  ];
  
  public function items(){ 
    return $this->hasMany(SaleItem::class); 
  }
  
  public function user(){ 
    return $this->belongsTo(User::class); 
  }
  
  public function cashier(){ 
    return $this->belongsTo(User::class, 'cashier_id'); 
  }
}

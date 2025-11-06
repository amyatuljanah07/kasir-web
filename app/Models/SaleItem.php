<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model {
  protected $fillable = ['sale_id','product_variant_id','quantity','price','discount','subtotal'];
  public function variant(){ return $this->belongsTo(ProductVariant::class,'product_variant_id'); }
}


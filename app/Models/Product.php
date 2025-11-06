<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
  protected $fillable = ['name','description','image','category', 'views_count', 'sales_count', 'is_early_access', 'early_access_until'];
  
  protected $casts = [
    'views_count' => 'integer',
    'sales_count' => 'integer',
    'is_early_access' => 'boolean',
    'early_access_until' => 'datetime',
  ];
  
  public function variants(){
    return $this->hasMany(ProductVariant::class);
  }
  
  /**
   * Increment views count
   */
  public function incrementViews()
  {
    $this->increment('views_count');
  }
  
  /**
   * Increment sales count
   */
  public function incrementSales($quantity = 1)
  {
    $this->increment('sales_count', $quantity);
  }
  
  /**
   * Scope untuk produk populer berdasarkan penjualan
   */
  public function scopePopular($query, $limit = 10)
  {
    return $query->orderBy('sales_count', 'desc')
      ->orderBy('views_count', 'desc')
      ->limit($limit);
  }

  /**
   * Check if product is in early access period
   */
  public function isEarlyAccess()
  {
    if (!$this->is_early_access) {
      return false;
    }

    if ($this->early_access_until && now()->greaterThan($this->early_access_until)) {
      return false;
    }

    return true;
  }

  /**
   * Check if user can access this product
   */
  public function canBeAccessedBy($user)
  {
    if (!$this->isEarlyAccess()) {
      return true; // Public access
    }

    // Only members can access early access products
    return $user && $user->membership && $user->membership->is_active;
  }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $guarded = [];
    
    protected $fillable = [
        'purchase_id',
        'product_id',
        'cost',
        'quantity',
        'total',
        'purchase_unit_id'
    ];
    
    protected $casts = [
        'cost' => 'decimal:2',
        'quantity' => 'decimal:3',
        'total' => 'decimal:2',
    ];
    
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'purchase_unit_id');
    }
}
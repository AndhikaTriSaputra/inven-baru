<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];
    
    protected $fillable = [
        'user_id',
        'Ref',
        'date',
        'provider_id',
        'warehouse_id',
        'GrandTotal',
        'paid_amount',
        'statut',
        'payment_statut',
        'notes',
        'image',
        'category_id'
    ];
    
    protected $casts = [
        'date' => 'date',
        'GrandTotal' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];
    
    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }
    
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function details()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
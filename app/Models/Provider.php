<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    protected $guarded = [];
    
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'tax_number'
    ];
    
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
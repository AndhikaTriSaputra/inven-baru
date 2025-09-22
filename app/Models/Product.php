<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    protected $fillable = [
        'name', 'code', 'type', 'brand_id', 'category_id', 'unit_id', 
        'Type_barcode', 'stock_alert', 'image', 'is_active'
    ];

    // Constants for approval status
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    /**
     * Generate a unique product code
     * Format: PRD + 9 digits (e.g., PRD123456789)
     */
    public static function generateUniqueCode()
    {
        do {
            $code = 'PRD' . str_pad(mt_rand(0, 999999999), 9, '0', STR_PAD_LEFT);
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Generate a product code based on category
     * Format: [Category Code] + [4 digits] (e.g., CAT0001)
     */
    public static function generateCodeByCategory($categoryId)
    {
        $category = DB::table('categories')->where('id', $categoryId)->first();
        $categoryCode = $category ? strtoupper(substr($category->name, 0, 3)) : 'PRD';
        
        do {
            $number = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            $code = $categoryCode . $number;
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Generate a sequential product code
     * Format: PRD + [next number] (e.g., PRD000001)
     */
    public static function generateSequentialCode()
    {
        $lastProduct = self::orderBy('id', 'desc')->first();
        $nextNumber = $lastProduct ? (intval(substr($lastProduct->code, 3)) + 1) : 1;
        
        do {
            $code = 'PRD' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
            $nextNumber++;
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Scope untuk mendapatkan produk yang sudah di-approve (visible untuk user biasa)
     */
    public function scopeApproved($query)
    {
        return $query->where('is_active', self::STATUS_APPROVED);
    }

    /**
     * Scope untuk mendapatkan produk yang pending approval
     */
    public function scopePending($query)
    {
        return $query->where('is_active', self::STATUS_PENDING);
    }

    /**
     * Scope untuk mendapatkan produk yang ditolak
     */
    public function scopeRejected($query)
    {
        return $query->where('is_active', self::STATUS_REJECTED);
    }

    /**
     * Check if product is approved
     */
    public function isApproved()
    {
        return $this->is_active == self::STATUS_APPROVED;
    }

    /**
     * Check if product is pending
     */
    public function isPending()
    {
        return $this->is_active == self::STATUS_PENDING;
    }

    /**
     * Check if product is rejected
     */
    public function isRejected()
    {
        return $this->is_active == self::STATUS_REJECTED;
    }

    /**
     * Get status text
     */
    public function getStatusTextAttribute()
    {
        switch ($this->is_active) {
            case self::STATUS_PENDING:
                return 'Pending';
            case self::STATUS_APPROVED:
                return 'Approved';
            case self::STATUS_REJECTED:
                return 'Rejected';
            default:
                return 'Unknown';
        }
    }

    /**
     * Get status badge class
     */
    public function getStatusBadgeClassAttribute()
    {
        switch ($this->is_active) {
            case self::STATUS_PENDING:
                return 'badge-warning';
            case self::STATUS_APPROVED:
                return 'badge-success';
            case self::STATUS_REJECTED:
                return 'badge-danger';
            default:
                return 'badge-secondary';
        }
    }

    /**
     * Relationships
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
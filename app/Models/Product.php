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
}
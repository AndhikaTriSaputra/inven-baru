<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

function isProductApproved($productId)
{
    // Check if product is approved (is active)
    return DB::table('products')->where('id', $productId)->value('is_active') == 1;
}

function isProductPendingApproval($productId)
{
    // Check if product is pending approval (is inactive)
    return DB::table('products')->where('id', $productId)->value('is_active') == 0;
}
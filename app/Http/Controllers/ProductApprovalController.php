<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ProductApprovalController extends Controller
{
    public function index()
    {
        $pendingApprovals = ProductApprovalController::pending()
            ->with(['creator'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $pendingApprovals
        ]);
    }

    public function approve($id)
    {
        // Check if user is admin
        if (auth()->user()->role_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can approve products.'
            ], 403);
        }

        $approval = ProductApproval::findOrFail($id);

        if ($approval->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This product has already been processed.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            // Get category, brand, and unit IDs
            $categoryId = DB::table('categories')->where('name', $approval->category)->value('id');
            $brandId = $approval->brand ? DB::table('brands')->where('name', $approval->brand)->value('id') : null;
            $unitId = $approval->unit ? DB::table('units')->where('ShortName', $approval->unit)->value('id') : null;

            // Create the actual product in the products table
            $productId = DB::table('products')->insertGetId([
                'name' => $approval->name,
                'code' => $approval->code,
                'type' => $approval->type,
                'category_id' => $categoryId,
                'brand_id' => $brandId,
                'unit_id' => $unitId,
                'description' => $approval->description,
                'image' => $approval->image,
                'stock_alert' => 0,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update approval status
            $approval->update([
                'status' => 'approved',
                'approved_by' => auth()->id(),
                'approved_at' => now(),
            ]);

            // Set cache for approval status
            Cache::put("product_approved_$productId", true, now()->addYears(10));

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product approved successfully.',
                'product_id' => $productId
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Error approving product: ' . $e->getMessage()
            ], 500);
        }
    }

    public function reject(Request $request, $id)
    {
        // Check if user is admin
        if (auth()->user()->role_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Only admin can reject products.'
            ], 403);
        }

        $approval = ProductApproval::findOrFail($id);

        if ($approval->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'This product has already been processed.'
            ], 400);
        }

        $approval->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
            'rejection_reason' => $request->input('reason', 'No reason provided'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product rejected successfully.'
        ]);
    }

    public function getPendingCount()
    {
        $count = ProductApproval::pending()->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
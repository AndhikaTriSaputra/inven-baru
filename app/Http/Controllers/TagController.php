<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    /**
     * Store a newly created tag via AJAX
     */
    public function storeAjax(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7'
        ]);

        $tagId = DB::table('tags')->insertGetId([
            'name' => $request->name,
            'color' => $request->color ?? '#3B82F6',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'success' => true,
            'tag' => [
                'id' => $tagId,
                'name' => $request->name,
                'color' => $request->color ?? '#3B82F6'
            ]
        ]);
    }
}
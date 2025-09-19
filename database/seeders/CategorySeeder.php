<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['code' => 'EL', 'name' => 'Electronics'],
            ['code' => 'FA', 'name' => 'Fashion'],
            ['code' => 'BK', 'name' => 'Books'],
            ['code' => 'HG', 'name' => 'Home & Garden'],
        ];

        foreach ($rows as $r) {
            $exists = DB::table('categories')->where('name', $r['name'])->exists();
            if (!$exists) {
                DB::table('categories')->insert([
                    'code' => $r['code'],
                    'name' => $r['name'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}



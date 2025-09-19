<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            ['name' => 'Generic', 'description' => null],
            ['name' => 'Acme', 'description' => 'Demo brand'],
        ];
        foreach ($rows as $r) {
            if (!DB::table('brands')->where('name',$r['name'])->exists()) {
                DB::table('brands')->insert([
                    'name' => $r['name'],
                    'description' => $r['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}



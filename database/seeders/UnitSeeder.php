<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'Piece', 'ShortName' => 'Pcs'],
            ['name' => 'Kilogram', 'ShortName' => 'Kg'],
            ['name' => 'Liter', 'ShortName' => 'L'],
        ];

        foreach ($units as $u) {
            $exists = DB::table('units')->where('name', $u['name'])->exists();
            if (!$exists) {
                DB::table('units')->insert([
                    'name' => $u['name'],
                    'ShortName' => $u['ShortName'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}



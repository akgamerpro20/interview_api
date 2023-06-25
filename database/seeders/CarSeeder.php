<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cars')->insert([
            [
                'name' => "Car 1",
                'price' => "10.5"
            ],
            [
                'name' => "Car 2",
                'price' => "8"
            ],
            [
                'name' => "Car 3",
                'price' => "9.15"
            ],
            [
                'name' => "Car 4",
                'price' => "5"
            ],
            [
                'name' => "Car 5",
                'price' => "20"
            ],
        ]);
    }
}
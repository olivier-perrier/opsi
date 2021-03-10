<?php

namespace Database\Seeders;

use App\Models\Test;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Test::factory(100000)->create();

        $datas = [];

        for ($i = 0; $i < 10000; $i++) {
            $datas[$i] = [
                'valueId' => 5,
                'realValue' => 5.5,
                'timestamp' => '2006-06-20 02:07:41',
            ];
        }

        for ($i=0; $i < 1000; $i++) { 
            DB::table('2020')->insert($datas);
        }
    }
}

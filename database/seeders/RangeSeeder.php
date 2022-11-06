<?php

namespace Database\Seeders;

use App\Models\Helpers\Range;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class RangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $range = Range::where('status', Config::get('custom.status.active'))->first();
        if ($range==null){ // if database empty
            $rangeList = [
                ['start' => '700.00', 'end' => '2500.00'],
                ['start' => '2501.00', 'end' => '4000.00'],
                ['start' => '4001.00', 'end' => '5000.00'],
                ['start' => '5001.00', 'end' => '10000.00'],
                ['start' => '10001.00', 'end' => '20000.00'],
                ['start' => '20001.00', 'end' => '45000.00'],
                ['start' => '45001.00', 'end' => '60000.00'],
                ['start' => '60001.00', 'end' => '180000.00'],
                ['start' => '280001.00', 'end' => '500000.00'],
            ];

            foreach($rangeList AS $key => $value):
                Range::create($value);
            endforeach;
        }
    }
}

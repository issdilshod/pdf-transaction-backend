<?php

namespace Database\Seeders;

use App\Models\Helpers\Holiday;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $holiday = Holiday::where('status', Config::get('custom.status.active'))->first();
        if ($holiday==null){ // if database empty
            $holidayList = [ // for 2022
                ['name' => 'New Year\'s Day', 'date' => '2022-01-01'],
                ['name' => 'Martin Luther King, Jr. Day', 'date' => '2022-01-17'],
                ['name' => 'President\'s Day (George Washington\'s Birthday)', 'date' => '2022-02-21'],
                ['name' => 'Memorial Day', 'date' => '2022-05-30'],
                ['name' => 'Juneteenth', 'date' => '2022-06-19'],
                ['name' => 'Independence Day', 'date' => '2022-07-04'],
                ['name' => 'Labor Day', 'date' => '2022-09-05'],
                ['name' => 'Indigenous Peoples\' Day (also observed as Columbus Day)', 'date' => '2022-10-10'],
                ['name' => 'Veterans Day', 'date' => '2022-11-11'],
                ['name' => 'Thanksgiving Day', 'date' => '2022-11-24'],
                ['name' => 'Christmas Day', 'date' => '2022-11-25']
            ];

            foreach($holidayList AS $key => $value):
                Holiday::create($value);
            endforeach;
        }
    }
}

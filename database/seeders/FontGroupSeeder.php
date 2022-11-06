<?php

namespace Database\Seeders;

use App\Models\Helpers\FontGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class FontGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fontGroup = FontGroup::where('status', Config::get('custom.status.active'))->first();
        if ($fontGroup==null){ // if database empty
            $fontGroupList = [
                [ 'name' => 'Connections'],
            ];

            foreach($fontGroupList AS $key => $value):
                FontGroup::create($value);
            endforeach;
        }
    }
}

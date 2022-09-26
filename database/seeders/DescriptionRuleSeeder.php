<?php

namespace Database\Seeders;

use App\Models\DescriptionRule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class DescriptionRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $descriptionRules = DescriptionRule::where('status', Config::get('custom.status.active'))->first();
        if ($descriptionRules==null){ // if empty by logic
            $descriptionRules_list = [
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'BOFA FIN CTR    ', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'DEPOSIT', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'WIRE TYPE:WIRE IN DATE:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'TIME:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'ET TRN:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'SEQ:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'ORIG:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'ID:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'SND', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'BK:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'TRANSFER', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'Confirmation#', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'DES:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'INDN:', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'CO', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.const'),
                    'value' => 'CCD', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.select'),
                    'value' => 'SELECT', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.type'),
                    'value' => 'TYPE', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.text'),
                    'value' => 'TEXT', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.random'),
                    'value' => 'RANDOM', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.month_day'),
                    'value' => 'MONTH/DAY', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.year_month_day'),
                    'value' => 'YEAR/MONTH/DAY', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.hours_minutes'),
                    'value' => 'HOURS/MINUTES', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.fullYear_month_day'),
                    'value' => 'FULLYEAR/MONTH/DAY', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.fullYear_month_day'),
                    'value' => 'FULLYEAR/MONTH/DAY', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value'),
                    'value' => 'CUSTOMER', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value'),
                    'value' => 'SENDER NAME', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value'),
                    'value' => 'SENDER ID', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value'),
                    'value' => 'COMPANY', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value'),
                    'value' => 'ORGANIZATION', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value_cut'),
                    'value' => 'CUSTOMER', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value_cut'),
                    'value' => 'SENDER NAME', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value_cut'),
                    'value' => 'SENDER ID', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value_cut'),
                    'value' => 'COMPANY', 
                ],
                [ 
                    'type' => Config::get('custom.descriptionRules.value_cut'),
                    'value' => 'ORGANIZATION', 
                ],
            ];

            foreach ($descriptionRules_list AS $key => $value):
                DescriptionRule::create($value);
            endforeach;
        }
    }
}

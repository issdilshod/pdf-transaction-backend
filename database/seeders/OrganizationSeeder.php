<?php

namespace Database\Seeders;

use App\Models\Partners\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organzation = Organization::where('status', Config::get('custom.status.active'))->first();
        if ($organzation==null){ // if database empty
            $organizationList = [
                ['name' => 'Bank of America, N.A.']
            ];

            foreach($organizationList AS $key => $value):
                Organization::create($value);
            endforeach;
        }
    }
}

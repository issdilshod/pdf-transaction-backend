<?php

namespace Database\Seeders;

use App\Models\Transactions\TransactionPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class TransactionPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactionPage = TransactionPage::where('status', Config::get('custom.status.active'))->first();
        if ($transactionPage==null){ // if database empty
            $transactionPageList = [
                ['start_offset' => '', 'end_offset' => ''],
                ['start_offset' => '', 'end_offset' => ''],
                ['start_offset' => '-1240', 'end_offset' => '-5100'],
                ['start_offset' => '-803', 'end_offset' => '-6083'],
                ['start_offset' => '-1240', 'end_offset' => '-6083'],
            ];

            foreach($transactionPageList AS $key => $value):
                TransactionPage::create([
                    'page' => ($key+1),
                    'start_offset' => $value['start_offset'],
                    'end_offset' => $value['end_offset'],
                ]);
            endforeach;
        }
    }
}

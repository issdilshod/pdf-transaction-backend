<?php

namespace Database\Seeders;

use App\Models\Transactions\TransactionType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $transactionType = TransactionType::where('status', Config::get('custom.status.active'))->first();
        if ($transactionType==null){ // if database empty
            $transactionTypeList = [
                ['name' => 'Deposits'],
                ['name' => 'Withdrawals']
            ];

            foreach($transactionTypeList AS $key => $value):
                TransactionType::create($value);
            endforeach;
        }
    }
}

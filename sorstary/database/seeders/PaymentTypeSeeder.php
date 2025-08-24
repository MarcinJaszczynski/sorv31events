<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Faker\Provider\ar_EG\Payment;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        PaymentType::create(
            [
                'name' => 'przelew',
                'desc' => '1',
            ],
            [
                'name' => 'gotówka',
                'desc' => '1',
            ],

        );
    }
}

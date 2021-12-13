<?php

namespace Database\Seeders;

use App\Models\Account;
use Faker\Factory;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
          Account::create(['name' =>$faker->company]);
        }
    }
}

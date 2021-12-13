<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed both users and books table with
     * same corresponding account id's.
     *
     * @return void
     */
    public function run()
    {
        $bookSeeder = new BookSeeder();
        $faker = Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $accountId = $faker->numberBetween(1, 5);
            $userId    = $i + 1;
            User::create(
                [
                    'account_id' => $accountId,
                    'name'       => $faker->name,
                    'email'      => $faker->email,
                    'password'   => Hash::make('password'),
                ]
            );

            $bookSeeder->seedbooks($accountId, $userId, $faker);
        }
    }
}

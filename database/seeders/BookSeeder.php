<?php

namespace Database\Seeders;

use App\Models\Book;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param int     $accountId
     * @param int     $userId
     *
     * @return void
     */
    public function seedbooks(int $accountId, int $userId, $faker)
    {
        for ($i = 0; $i < 5; $i++) {
            Book::create(
                [
                    'account_id'  => $accountId,
                    'user_id'     => $userId,
                    'title'       => $faker->name,
                    'author'      => $faker->name,
                    'released_at' => Carbon::now()->subYears(rand(0, 4)),
                    'created_at'  => Carbon::now()->subDays(rand(0, 4)),
                    'updated_at'  => Carbon::now(),
                ]
            );
        }
    }
}

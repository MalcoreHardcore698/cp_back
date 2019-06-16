<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $faker;

    public function __construct()
    {
    }

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    }

    protected function fakeFine(int $id): array
    {
        return [
            'fine_id' => $id,
            'title' => '',
        ];
    }
}

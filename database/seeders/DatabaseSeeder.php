<?php

use Database\Seeders\MatierSeeder;
use Illuminate\Database\Seeder;
use App\Models\Matier; // Adjust the namespace if needed

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(MatierSeeder::class);
    }
}

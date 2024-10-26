<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Matier; // Import your model here

class MatierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bgs = ['symphonie', '.NetCore', 'Go', 'Flask', 'Math', 'Vue.js'];

        foreach($bgs as  $bg){
            Matier::create(['Name' => $bg]); // Make sure you're using the correct model name
        }
    }
}

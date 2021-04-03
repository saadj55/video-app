<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Videos;
class VideoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Videos::factory()
            ->count(50)
            ->hasPosts(1)
            ->create();
    }
}

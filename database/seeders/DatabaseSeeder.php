<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProductionRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->state(['roles' => \json_encode(['admin'])])->createOne();

        User::factory(10)->create();

        ProductionRole::factory(31)->create();
    }
}

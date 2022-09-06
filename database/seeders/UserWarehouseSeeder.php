<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserWarehouseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => ['user', 'warehouse']])
            ->createOne();
    }
}

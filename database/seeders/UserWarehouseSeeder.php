<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserWarehouseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Warehouse]])
            ->createOne();
    }
}

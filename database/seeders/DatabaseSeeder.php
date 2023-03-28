<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Bookable;
use App\Models\BookableCategory;
use App\Models\Booking;
use App\Models\Configuration;
use App\Models\FinalCopy;
use App\Models\ProductionCategory;
use App\Models\ProductionRole;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Configuration::factory()->createOne();

        User::factory()
            ->state(['email' => 'contato@cinemauff.com.br'])
            ->state(['is_enabled' => true])
            ->state(['is_confirmed' => true])
            ->state(['roles' => [UserRole::Admin]])
            ->createOne();

        User::factory()->state(['roles' => [UserRole::Department]])->count(3)->create();

        User::factory()->state(['roles' => [UserRole::Warehouse]])->count(3)->create();

        User::factory(30)->create();

        ProductionCategory::factory(31)->create();

        ProductionRole::factory(31)->create();

        Project::factory(31)->create();

        // FinalCopy::factory(31)->create();

        BookableCategory::factory(31)->create();

        Bookable::factory(31)->create();

        Booking::factory(31)->create();
    }
}

<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Bookable;
use App\Models\BookableCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookableTest extends TestCase implements CrudTestInterface, HasVersionsTestInterface
{
    use RefreshDatabase, CrudTestTrait, HasVersionsTestTrait;

    protected string $modelClass = Bookable::class;

    protected string $baseApiUrl = 'api/reservaveis';

    protected string $tableName = 'bookables';

    /**
     * @return array<string,mixed>
     */
    protected function getCreateRequest(): array
    {
        $bookableCategory = BookableCategory::factory()->createOne();

        $users = User::factory()->count(2)->create();

        return [
            'identifier' => '11.36',
            'name' => 'Kit Lente Zeiss',
            'bookable_category' => $bookableCategory->toArray(),
            'inventory_number' => '423182',
            'serial_number' => null,
            'accessories' => '21mm; 28mm; 35mm',
            'notes' => 'Duas lentes (50mm e 85mm) foram retiradas pelo departamento de cinema para manutenção',
            'is_under_maintenance' => false,
            'is_return_overdue' => false,
            'users' => $users->toArray()
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getCreateDatabaseFields(): array
    {
        return [
            'identifier' => '11.36',
            'name' => 'Kit Lente Zeiss',
            'inventory_number' => '423182',
            'serial_number' => null,
            'accessories' => '21mm; 28mm; 35mm',
            'notes' => 'Duas lentes (50mm e 85mm) foram retiradas pelo departamento de cinema para manutenção',
            'is_under_maintenance' => false,
            'is_return_overdue' => false,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateRequest(): array
    {
        $bookableCategory = BookableCategory::factory()->createOne();

        return [
            'identifier' => '18.052',
            'name' => 'Fresnel 600W 110V 3200K',
            'bookable_category' => $bookableCategory->toArray(),
            'inventory_number' => null,
            'serial_number' => null,
            'accessories' => null,
            'notes' => null,
            'is_under_maintenance' => true,
            'is_return_overdue' => false,
            'users' => null,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'identifier' => '18.052',
            'name' => 'Fresnel 600W 110V 3200K',
            'inventory_number' => null,
            'serial_number' => null,
            'accessories' => null,
            'notes' => null,
            'is_under_maintenance' => true,
            'is_return_overdue' => false,
        ];
    }
}

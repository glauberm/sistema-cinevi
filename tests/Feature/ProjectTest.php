<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Project;
use App\Models\ProductionCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase implements CrudTestInterface, HasVersionsTestInterface
{
    use RefreshDatabase, CrudTestTrait, HasVersionsTestTrait;

    protected string $modelClass = Project::class;

    protected string $baseApiUrl = 'api/projetos';

    protected string $tableName = 'projects';

    /**
     * @return array<string,mixed>
     */
    protected function getCreateRequest(): array
    {
        $owner = User::factory()->createOne();

        $productionCategory = ProductionCategory::factory()->createOne();

        $professor = User::factory()->createOne();

        $directors = User::factory()->count(3)->create();

        $producers = User::factory()->count(3)->create();

        $photographyDirectors = User::factory()->count(3)->create();

        $soundDirectors = User::factory()->count(3)->create();

        $artDirectors = User::factory()->count(3)->create();

        return [
            'title' => 'Capoeira e Luz',
            'synopsis' => 'Ensaio fotográfico que busca experimentar uma relação entre os movimentos corpóreos pela capoeira e a técnica fotográfica conhecida como Light Painting',
            'genres' => ['Documentário', 'Experimental'],
            'capture_format' => 'Digital',
            'capture_notes' => null,
            'venues' => 'IACS',
            'pre_production_date' => '2019-11-24',
            'production_date' => '2019-11-30',
            'post_production_date' => '2019-12-03',
            'has_attended_photography_discipline' => true,
            'has_attended_sound_discipline' => true,
            'has_attended_art_discipline' => true,
            'owner' => $owner->toArray(),
            'production_category' => $productionCategory->toArray(),
            'professor' => $professor->toArray(),
            'directors' => $directors->toArray(),
            'producers' => $producers->toArray(),
            'photography_directors' => $photographyDirectors->toArray(),
            'sound_directors' => $soundDirectors->toArray(),
            'art_directors' => $artDirectors->toArray(),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getCreateDatabaseFields(): array
    {
        return [
            'title' => 'Capoeira e Luz',
            'synopsis' => 'Ensaio fotográfico que busca experimentar uma relação entre os movimentos corpóreos pela capoeira e a técnica fotográfica conhecida como Light Painting',
            'capture_format' => 'Digital',
            'capture_notes' => null,
            'venues' => 'IACS',
            'pre_production_date' => '2019-11-24',
            'production_date' => '2019-11-30',
            'post_production_date' => '2019-12-03',
            'has_attended_photography_discipline' => true,
            'has_attended_sound_discipline' => true,
            'has_attended_art_discipline' => true,
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateRequest(): array
    {
        $owner = User::factory()->createOne();

        $productionCategory = ProductionCategory::factory()->createOne();

        $professor = User::factory()->createOne();

        $directors = User::factory()->count(3)->create();

        $producers = User::factory()->count(3)->create();

        $photographyDirectors = User::factory()->count(3)->create();

        $soundDirectors = User::factory()->count(3)->create();

        $artDirectors = User::factory()->count(3)->create();

        return [
            'title' => 'Imagine Só',
            'synopsis' => 'Manuela e Matheus nasceram no mesmo dia e unidos não só como irmãos, também na imaginação. Eles transformam qualquer coisa em diversão e não precisam de muito pra se divertir. Uma aparição repentina os fazem perceber que nem todos vivem na mesma rotina.',
            'genres' => ['Ficção'],
            'capture_format' => 'Digital',
            'capture_notes' => null,
            'venues' => 'Itaipuaçu, Maricá - RJ',
            'pre_production_date' => '2019-11-10',
            'production_date' => '2020-03-13',
            'post_production_date' => '2020-03-27',
            'has_attended_photography_discipline' => true,
            'has_attended_sound_discipline' => true,
            'has_attended_art_discipline' => true,
            'owner' => $owner->toArray(),
            'production_category' => $productionCategory->toArray(),
            'professor' => $professor->toArray(),
            'directors' => $directors->toArray(),
            'producers' => $producers->toArray(),
            'photography_directors' => $photographyDirectors->toArray(),
            'sound_directors' => $soundDirectors->toArray(),
            'art_directors' => $artDirectors->toArray(),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'title' => 'Imagine Só',
            'synopsis' => 'Manuela e Matheus nasceram no mesmo dia e unidos não só como irmãos, também na imaginação. Eles transformam qualquer coisa em diversão e não precisam de muito pra se divertir. Uma aparição repentina os fazem perceber que nem todos vivem na mesma rotina.',
            'capture_format' => 'Digital',
            'capture_notes' => null,
            'venues' => 'Itaipuaçu, Maricá - RJ',
            'pre_production_date' => '2019-11-10',
            'production_date' => '2020-03-13',
            'post_production_date' => '2020-03-27',
            'has_attended_photography_discipline' => true,
            'has_attended_sound_discipline' => true,
            'has_attended_art_discipline' => true,
        ];
    }
}

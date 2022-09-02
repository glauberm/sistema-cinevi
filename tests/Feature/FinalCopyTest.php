<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\FinalCopy;
use App\Models\ProductionCategory;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinalCopyTest extends TestCase implements CrudTestInterface, HasVersionsTestInterface
{
    use RefreshDatabase, CrudTestTrait, HasVersionsTestTrait;

    protected string $modelClass = FinalCopy::class;

    protected string $baseApiUrl = 'api/copias-finais';

    protected string $tableName = 'final_copies';

    /**
     * @return array<string,mixed>
     */
    protected function getCreateRequest(): array
    {
        $owner = User::factory()->createOne();

        $productionCategory = ProductionCategory::factory()->createOne();

        $professor = User::factory()->createOne();

        return [
            'title' => 'Capoeira e Luz',
            'synopsis' => 'Ensaio fotográfico que busca experimentar uma relação entre os movimentos corpóreos pela capoeira e a técnica fotográfica conhecida como Light Painting',
            'genres' => ['Documentário', 'Experimental'],
            'capture_format' => 'Digital',
            'capture_notes' => null,
            'venues' => 'IACS',
            'video_url' => 'https://www.youtube.com/watch?v=Jcj6h8Z8P4A',
            'video_password' => null,
            'chromia' => null,
            'proportion' => null,
            'format' => null,
            'duration' => null,
            'native_digital_format' => null,
            'codec' => null,
            'container' => null,
            'bitrate' => null,
            'fps' => null,
            'sound' => null,
            'digital_sound_resolution' => null,
            'digital_matrix_support' => null,
            'camera' => null,
            'editing_software' => null,
            'sound_capture_equipment' => null,
            'budget' => null,
            'financing_sources' => null,
            'supporters' => null,
            'has_dcp' => null,
            'cast' => null,
            'participations' => null,
            'prizes' => null,
            'confirmed' => false,
            'owner' => $owner->toArray(),
            'production_category' => $productionCategory->toArray(),
            'professor' => $professor->toArray(),
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
            'video_url' => 'https://www.youtube.com/watch?v=Jcj6h8Z8P4A',
            'video_password' => null,
            'chromia' => null,
            'proportion' => null,
            'format' => null,
            'duration' => null,
            'native_digital_format' => null,
            'codec' => null,
            'container' => null,
            'bitrate' => null,
            'fps' => null,
            'sound' => null,
            'digital_sound_resolution' => null,
            'digital_matrix_support' => null,
            'camera' => null,
            'editing_software' => null,
            'sound_capture_equipment' => null,
            'budget' => null,
            'financing_sources' => null,
            'supporters' => null,
            'has_dcp' => null,
            'cast' => null,
            'participations' => null,
            'prizes' => null,
            'confirmed' => false,
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

        return [
            'title' => 'Chega Mais',
            'synopsis' => 'A obra audiovisual realizada é um videoclipe musical de lançamento da música Chega Mais da artista independente do Rio de Janeiro, Rafaela Varella.',
            'genres' => ['Outro(s)'],
            'capture_format' => 'Vídeo',
            'capture_notes' => null,
            'venues' => 'Freguesia, Rio de Janeiro - RJ',
            'video_url' => 'https://www.youtube.com/watch?v=QJsgSH28Wgo',
            'video_password' => null,
            'chromia' => null,
            'proportion' => null,
            'format' => null,
            'duration' => null,
            'native_digital_format' => null,
            'codec' => null,
            'container' => null,
            'bitrate' => null,
            'fps' => null,
            'sound' => null,
            'digital_sound_resolution' => null,
            'digital_matrix_support' => null,
            'camera' => null,
            'editing_software' => null,
            'sound_capture_equipment' => null,
            'budget' => null,
            'financing_sources' => null,
            'supporters' => null,
            'has_dcp' => null,
            'cast' => null,
            'participations' => null,
            'prizes' => null,
            'confirmed' => false,
            'owner' => $owner->toArray(),
            'production_category' => $productionCategory->toArray(),
            'professor' => $professor->toArray(),
        ];
    }

    /**
     * @return array<string,mixed>
     */
    protected function getUpdateDatabaseFields(): array
    {
        return [
            'title' => 'Chega Mais',
            'synopsis' => 'A obra audiovisual realizada é um videoclipe musical de lançamento da música Chega Mais da artista independente do Rio de Janeiro, Rafaela Varella.',
            'capture_format' => 'Vídeo',
            'capture_notes' => null,
            'venues' => 'Freguesia, Rio de Janeiro - RJ',
            'video_url' => 'https://www.youtube.com/watch?v=QJsgSH28Wgo',
            'video_password' => null,
            'chromia' => null,
            'proportion' => null,
            'format' => null,
            'duration' => null,
            'native_digital_format' => null,
            'codec' => null,
            'container' => null,
            'bitrate' => null,
            'fps' => null,
            'sound' => null,
            'digital_sound_resolution' => null,
            'digital_matrix_support' => null,
            'camera' => null,
            'editing_software' => null,
            'sound_capture_equipment' => null,
            'budget' => null,
            'financing_sources' => null,
            'supporters' => null,
            'has_dcp' => null,
            'cast' => null,
            'participations' => null,
            'prizes' => null,
            'confirmed' => false,
        ];
    }
}

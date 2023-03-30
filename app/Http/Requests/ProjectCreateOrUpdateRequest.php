<?php

namespace App\Http\Requests;

use App\Enums\UserRole;
use App\Rules\UserHasProjectWithoutFinalCopyRule;
use App\Services\ProjectService;
use App\Services\UserService;
use Carbon\CarbonImmutable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProjectCreateOrUpdateRequest extends FormRequest
{
    public function authorize(ProjectService $service): bool
    {
        if ($id = $this->route('id')) {
            $project = $service->get(intval($id), ['owner']);

            return Gate::allows('hasRole', UserRole::Admin)
                || Gate::allows('hasRole', UserRole::Department)
                || Gate::allows('isUser', $project->owner_id);
        }

        return true;
    }

    protected function failedAuthorization(): void
    {
        throw new AuthorizationException(
            'Você não tem permissão para editar este projeto.'
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function rules(UserService $userService): array
    {
        return [
            'title' => ['required', 'string'],
            'synopsis' => ['required', 'string'],
            'genres' => ['required', 'string'],
            'capture_format' => ['nullable', 'string'],
            'capture_notes' => ['nullable', 'string'],
            'venues' => ['nullable', 'string'],
            'pre_production_date' => ['required', 'string', 'date_format:Y-m-d'],
            'production_date' => ['required', 'string', 'date_format:Y-m-d'],
            'post_production_date' => ['required', 'string', 'date_format:Y-m-d'],
            'has_attended_photography_discipline' => ['required', 'accepted'],
            'has_attended_sound_discipline' => ['required', 'accepted'],
            'has_attended_art_discipline' => ['required', 'accepted'],
            'owner_id' => ['required', 'integer', new UserHasProjectWithoutFinalCopyRule($userService)],
            'production_category_id' => ['required', 'integer'],
            'professor_id' => ['required', 'integer'],
            'directors' => ['required', 'array'],
            'directors.*.id' => ['required', 'integer'],
            'producers' => ['required', 'array'],
            'producers.*.id' => ['required', 'integer'],
            'photography_directors' => ['required', 'array'],
            'photography_directors.*.id' => ['required', 'integer'],
            'sound_directors' => ['required', 'array'],
            'sound_directors.*.id' => ['required', 'integer'],
            'art_directors' => ['required', 'array'],
            'art_directors.*.id' => ['required', 'integer'],
        ];
    }

    /**
     * @return array<string,string>
     */
    public function messages(): array
    {
        $dateFormat = CarbonImmutable::now()->format('Y-m-d');

        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser uma string.',
            'synopsis.required' => 'A sinopse é obrigatória.',
            'synopsis.string' => 'A sinopse deve ser uma string.',
            'genres.required' => 'Você deve informar o(s) gênero(s) do projeto.',
            'genres.string' => 'O(s) gênero(s) do projeto devem ser uma string.',
            'capture_format.string' => 'O formato de captação deve ser uma string.',
            'capture_notes.string' => 'Os detalhes de captação deve ser uma string.',
            'venues.string' => 'As locações devem ser informadas em uma string.',
            'pre_production_date.string' => 'O formato da data de pré-produção está incorreto.',
            'pre_production_date.required' => 'A data de pré-produção é obrigatória.',
            'pre_production_date.date_format' => "A data de pré-produção deve estar no seguinte formato: {$dateFormat}",
            'production_date.string' => 'O formato da data de produção está incorreto.',
            'production_date.required' => 'A data de produção é obrigatória.',
            'production_date.date_format' => "A data de produção deve estar no seguinte formato: {$dateFormat}",
            'post_production_date.string' => 'O formato da data de pós-produção está incorreto.',
            'post_production_date.required' => 'A data de pós-produção é obrigatória.',
            'post_production_date.date_format' => "A data de pós-produção deve estar no seguinte formato: {$dateFormat}",
            'has_attended_photography_discipline.accepted' => 'A informação de se já cursou a disciplina de Fotografia e Iluminação deve ser um valor booleano.',
            'has_attended_photography_discipline.required' => 'É necessário confirmar que a disciplina de Fotografia e Iluminação já foi cursada.',
            'has_attended_sound_discipline.accepted' => 'A informação de se já cursou a disciplina de Técnica de Som em Cinema e Audiovisual deve ser um valor booleano.',
            'has_attended_sound_discipline.required' => 'É necessário confirmar que a disciplina de Técnica de Som em Cinema e Audiovisual já foi cursada.',
            'has_attended_art_discipline.accepted' => 'A informação de se já cursou a disciplina de Design Visual deve ser um valor booleano.',
            'has_attended_art_discipline.required' => 'É necessário confirmar que a disciplina de Design Visual já foi cursada.',
            'owner_id.required' => 'Você deve informar o responsável pelo projeto.',
            'owner_id.integer' => 'O identificador do responsável do projeto deve ser um inteiro.',
            'production_category_id.required' => 'Você deve informar a modalidade do projeto.',
            'production_category_id.integer' => 'O identificador da modalidade do projeto deve ser um inteiro.',
            'professor_id.required' => 'Você deve informar o professor responsável pelo projeto.',
            'professor_id.integer' => 'O identificador do professor responsável do projeto deve ser um inteiro.',
            'directors.array' => 'O formato dos diretores está incorreto.',
            'directors.required' => 'É obrigatório informar os diretores associados ao projeto.',
            'directors.*.id.integer' => 'O formato dos diretores está incorreto.',
            'directors.*.id.required' => 'É obrigatório informar os diretores associados ao projeto.',
            'producers.array' => 'O formato dos produtores está incorreto.',
            'producers.required' => 'É obrigatório informar os produtores associados ao projeto.',
            'producers.*.id.integer' => 'O formato dos produtores está incorreto.',
            'producers.*.id.required' => 'É obrigatório informar os produtores associados ao projeto.',
            'photography_directors.array' => 'O formato dos diretores de fotografia está incorreto.',
            'photography_directors.required' => 'É obrigatório informar os diretores de fotografia associados ao projeto.',
            'photography_directors.*.id.integer' => 'O formato dos diretores de fotografia está incorreto.',
            'photography_directors.*.id.required' => 'É obrigatório informar os diretores de fotografia associados ao projeto.',
            'sound_directors.array' => 'O formato dos diretores de som está incorreto.',
            'sound_directors.required' => 'É obrigatório informar os diretores de som associados ao projeto.',
            'sound_directors.*.id.integer' => 'O formato dos diretores de som está incorreto.',
            'sound_directors.*.id.required' => 'É obrigatório informar os diretores de som associados ao projeto.',
            'art_directors.array' => 'O formato dos diretores de arte está incorreto.',
            'art_directors.required' => 'É obrigatório informar os diretores de arte associados ao projeto.',
            'art_directors.*.id.integer' => 'O formato dos diretores de arte está incorreto.',
            'art_directors.*.id.required' => 'É obrigatório informar os diretores de arte associados ao projeto.',
        ];
    }
}
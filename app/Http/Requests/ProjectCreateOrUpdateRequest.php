<?php

namespace App\Http\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ProjectCreateOrUpdateRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $owner = $this->input('owner');

        $productionCategory = $this->input('production_category');

        $professor = $this->input('professor');

        if (! \is_array($owner) || ! \array_key_exists('id', $owner)) {
            throw new BadRequestHttpException('O responsável pelo projeto foi informado em um formato inválido.');
        }

        if (! \is_array($productionCategory) || ! \array_key_exists('id', $productionCategory)) {
            throw new BadRequestHttpException('A modalidade do projeto foi informada em um formato inválido.');
        }

        if (! \is_array($professor) || ! \array_key_exists('id', $professor)) {
            throw new BadRequestHttpException('O professor responsável pelo projeto foi informado em um formato inválido.');
        }

        $this->merge(['owner_id' => $owner['id']]);

        $this->merge(['production_category_id' => $productionCategory['id']]);

        $this->merge(['professor_id' => $professor['id']]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,string[]>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'synopsis' => ['required', 'string'],
            'genres' => ['required', 'array'],
            'genres.*' => ['required', 'string'],
            'capture_format' => ['nullable', 'string'],
            'capture_notes' => ['nullable', 'string'],
            'venues' => ['nullable', 'string'],
            'pre_production_date' => ['required', 'string', 'date_format:Y-m-d'],
            'production_date' => ['required', 'string', 'date_format:Y-m-d'],
            'post_production_date' => ['required', 'string', 'date_format:Y-m-d'],
            'has_attended_photography_discipline' => ['required', 'accepted'],
            'has_attended_sound_discipline' => ['required', 'accepted'],
            'has_attended_art_discipline' => ['required', 'accepted'],
            'owner_id' => ['required', 'integer'],
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
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        $dateFormat = CarbonImmutable::now()->format('Y-m-d');

        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser uma string.',
            'synopsis.required' => 'A sinopse é obrigatória.',
            'synopsis.string' => 'A sinopse deve ser uma string.',
            'genres.required' => 'Você deve informar o(s) gênero(s) do projeto.',
            'genres.array' => 'O(s) gênero(s) do projeto devem estar em um array.',
            'genres.*.required' => 'Você deve informar o(s) gênero(s) do projeto.',
            'genres.*.string' => 'O(s) gênero(s) do projeto devem estar em um array de strings.',
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

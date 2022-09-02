<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FinalCopyCreateOrUpdateRequest extends FormRequest
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

        if (!\is_array($owner) || !\array_key_exists('id', $owner)) {
            throw new BadRequestHttpException('O responsável pela cópia final foi informado em um formato inválido.');
        }

        if (!\is_array($productionCategory) || !\array_key_exists('id', $productionCategory)) {
            throw new BadRequestHttpException('A modalidade da cópia final foi informada em um formato inválido.');
        }

        if (!\is_array($professor) || !\array_key_exists('id', $professor)) {
            throw new BadRequestHttpException('O professor responsável pela cópia final foi informado em um formato inválido.');
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
            'capture_format' => ['required', 'string'],
            'capture_notes' => ['nullable', 'string'],
            'venues' => ['required', 'string'],
            'video_url' => ['nullable', 'string', 'url'],
            'video_password' => ['nullable', 'string'],
            'chromia' => ['nullable', 'string'],
            'proportion' => ['nullable', 'string'],
            'format' => ['nullable', 'string'],
            'duration' => ['nullable', 'string'],
            'native_digital_format' => ['nullable', 'string'],
            'codec' => ['nullable', 'string'],
            'container' => ['nullable', 'string'],
            'bitrate' => ['nullable', 'string'],
            'fps' => ['nullable', 'string'],
            'sound' => ['nullable', 'string'],
            'digital_sound_resolution' => ['nullable', 'string'],
            'digital_matrix_support' => ['nullable', 'string'],
            'camera' => ['nullable', 'string'],
            'editing_software' => ['nullable', 'array'],
            'editing_software.*' => ['nullable', 'string'],
            'sound_capture_equipment' => ['nullable', 'string'],
            'budget' => ['nullable', 'string'],
            'financing_sources' => ['nullable', 'array'],
            'financing_sources.*' => ['nullable', 'string'],
            'supporters' => ['nullable', 'string'],
            'has_dcp' => ['nullable', 'boolean'],
            'cast' => ['nullable', 'string'],
            'participations' => ['nullable', 'string'],
            'prizes' => ['nullable', 'string'],
            'confirmed' => ['required', 'boolean'],
            'owner_id' => ['required', 'integer'],
            'production_category_id' => ['required', 'integer'],
            'professor_id' => ['required', 'integer'],
            'production_roles' => ['nullable', 'array'],
            'production_roles.*.production_role_id' => ['nullable', 'integer'],
            'production_roles.*.users' => ['nullable', 'array'],
            'production_roles.*.users.*.id' => ['nullable', 'integer'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string,string>
     */
    public function messages()
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'title.string' => 'O título deve ser uma string.',
            'synopsis.required' => 'A sinopse é obrigatória.',
            'synopsis.string' => 'A sinopse deve ser uma string.',
            'genres.required' => 'Você deve informar o(s) gênero(s) da cópia final.',
            'genres.array' => 'O(s) gênero(s) da cópia final devem estar em um array.',
            'genres.*.required' => 'Você deve informar o(s) gênero(s) da cópia final.',
            'genres.*.string' => 'O(s) gênero(s) da cópia final devem estar em um array de strings.',
            'capture_format.required' => 'O formato de captação é obrigatório.',
            'capture_format.string' => 'O formato de captação deve ser uma string.',
            'capture_notes.string' => 'Os detalhes de captação deve ser uma string.',
            'venues.required' => 'Você deve informar as locações da cópia final.',
            'venues.string' => 'As locações devem ser informadas em uma string.',
            'video_url.string' => 'A URL do vídeo deve ser uma string.',
            'video_url.url' => 'A URL do vídeo está malformatada.',
            'video_password.string' => 'A senha do vídeo deve ser uma string.',
            'chromia.string' => 'A cromia deve ser uma string.',
            'proportion.string' => 'A proporção deve ser uma string.',
            'format.string' => 'O formato de vídeo deve ser uma string.',
            'duration.string' => 'A duração do vídeo deve ser uma string.',
            'native_digital_format.string' => 'O formato digital nativo deve ser uma string.',
            'codec.string' => 'O codec deve ser uma string.',
            'container.string' => 'O container deve ser uma string.',
            'bitrate.string' => 'O bitrate deve ser uma string.',
            'fps.string' => 'O FPS deve ser uma string.',
            'sound.string' => 'O som deve ser uma string.',
            'digital_sound_resolution.string' => 'A resolução do áudio digital deve ser uma string.',
            'digital_matrix_support.string' => 'O suporte da matriz digital deve ser uma string.',
            'camera.string' => 'A câmera deve ser uma string.',
            'editing_software.array' => 'Os softwares de edição devem estar em um array.',
            'editing_software.*.string' => 'Os softwares de edição devem ser uma string.',
            'sound_capture_equipment.string' => 'O equipamento de captura de som ser uma string.',
            'budget.string' => 'O equipamento de captura de som ser uma string.',
            'financing_sources.array' => 'As fontes de financiamento devem estar em um array.',
            'financing_sources.*.string' => 'As fontes de financiamento devem ser uma string.',
            'supporters.string' => 'Os apoiadores devem ser uma string.',
            'has_dcp.boolean' => 'A informação de se foi DCP deve ser um valor boolean.',
            'cast.string' => 'O elenco deve ser uma string.',
            'participations.string' => 'As participações deve ser uma string.',
            'prizes.string' => 'Os prêmios devem ser uma string.',
            'owner_id.required' => 'Você deve informar o responsável pela cópia final.',
            'owner_id.integer' => 'O identificador do responsável da cópia final deve ser um inteiro.',
            'production_category_id.required' => 'Você deve informar a modalidade da cópia final.',
            'production_category_id.integer' => 'O identificador da modalidade da cópia final deve ser um inteiro.',
            'professor_id.required' => 'Você deve informar o professor responsável pela cópia final.',
            'professor_id.integer' => 'O identificador do professor responsável da cópia final deve ser um inteiro.',
            'production_roles.array' => 'A ficha técnica deve estar em um array.',
            'production_roles.*.production_role_id.integer' => 'Os identificadores das funções da ficha técnica devem ser um array.',
            'production_roles.*.users.array' => 'As equipes da ficha técnica devem ser arrays.',
            'production_roles.*.users.*.id.integer' => 'Os identificadores das equipes da ficha técnica deve ser um array.'
        ];
    }
}

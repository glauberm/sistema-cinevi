<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int                         $id
 * @property string                      $action
 * @property string                      $message
 * @property array<mixed, mixed>|string  $payload
 * @property string                      $user_ip
 * @property string                      $user_agent
 * @property string                      $user_string
 * @property Carbon                      $created_at
 * @property Carbon                      $updated_at
 * @property User                        $user
 */
class Version extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['action', 'message', 'payload', 'user_ip', 'user_agent', 'user_string'];

    /**
     * Retorna o usuário associado à versão.
     *
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define o id do usuário através dos dados da requisição.
     *
     * @param array<string, mixed> $user
     * @return void
     */
    public function setUserAttribute(array $user): void
    {
        $this->attributes['user_id'] = $user['id'];
    }
}

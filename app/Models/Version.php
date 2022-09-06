<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer              $id
 * @property string               $action
 * @property string               $message
 * @property array<string,mixed>  $payload
 * @property string               $user_ip
 * @property string               $user_agent
 * @property string               $user_string
 * @property CarbonImmutable      $datetime
 * @property User                 $user
 */
class Version extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'action',
        'message',
        'payload',
        'user_ip',
        'user_agent',
        'user_string',
        'datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'payload' => 'array',
        'datetime' => 'immutable_datetime',
    ];

    /**
     * Retorna o usuário associado à versão.
     *
     * @return BelongsTo<User, self>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

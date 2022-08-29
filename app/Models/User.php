<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int                $id
 * @property string             $name
 * @property string             $email
 * @property string             $password
 * @property string             $phone
 * @property string             $identifier
 * @property bool               $is_enabled
 * @property bool               $is_confirmed
 * @property string|array       $roles
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

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
        'name',
        'email',
        'password',
        'phone',
        'identifier',
        'is_enabled',
        'is_confirmed',
        'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * @return Attribute<callable, callable>
     */
    public function password(): Attribute
    {
        return Attribute::make(set: fn (string $value) => Hash::make($value));
    }

    /**
     * @return Attribute<callable, callable>
     */
    public function roles(): Attribute
    {
        return Attribute::make(get: [$this, 'getRoles'], set: [$this, 'setRoles']);
    }

    /**
     * @param  string    $value
     * @return string[]
     */
    protected function getRoles(string $value): array
    {
        $array = \json_decode($value, true);

        if (!\is_array($array)) {
            throw new \JsonException('Erro ao decodificar JSON');
        }

        return $array;
    }

    /**
     * @param  string[]|string $value
     * @return string
     */
    protected function setRoles(array|string $value): string
    {
        if (\is_string($value)) {
            return $value;
        }

        $string = \json_encode($value);

        if (!\is_string($string)) {
            throw new \JsonException('Erro ao codificar JSON');
        }

        return $string;
    }
}

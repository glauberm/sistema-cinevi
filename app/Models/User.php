<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer   $id
 * @property string    $name
 * @property string    $email
 * @property string    $password
 * @property string    $phone
 * @property string    $identifier
 * @property bool      $is_enabled
 * @property bool      $is_confirmed
 * @property string[]  $roles
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
     * @var array<int,string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'is_confirmed' => 'boolean',
        'roles' => 'array',
    ];

    /**
     * @return Attribute<callable, callable>
     */
    public function password(): Attribute
    {
        return Attribute::make(set: fn (string $value) => Hash::make($value));
    }
}

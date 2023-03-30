<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProjectUserRole;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property int                  $id
 * @property string               $name
 * @property string               $email
 * @property string               $password
 * @property string               $phone
 * @property string               $identifier
 * @property bool                 $is_enabled
 * @property bool                 $is_confirmed
 * @property string[]             $roles
 * @property Collection<Project>  $projects
 * @property Collection<Project>  $projectsAsDirector
 * @property Collection<Project>  $projectsAsProducer
 * @property Collection<Project>  $projectsAsPhotographyDirector
 * @property Collection<Project>  $projectsAsSoundDirector
 * @property Collection<Project>  $projectsAsArtDirector
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory;

    /**
     * The column name of the "remember me" token.
     *
     * @var string
     */
    protected $rememberTokenName = null;

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
     * @return Attribute<callable,callable>
     */
    public function password(): Attribute
    {
        return Attribute::make(set: fn (string $value) => Hash::make($value));
    }

    /**
     * @return HasMany<Project>
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class, 'owner_id');
    }

    /**
     * @return HasMany<Project>
     */
    public function projectsAsDirector(): HasMany
    {
        return $this->hasMany(Project::class)
            ->wherePivot('role', '=', ProjectUserRole::Director);
    }

    /**
     * @return HasMany<Project>
     */
    public function projectsAsProducer(): HasMany
    {
        return $this->hasMany(Project::class)
            ->wherePivot('role', '=', ProjectUserRole::Producer);
    }

    /**
     * @return HasMany<Project>
     */
    public function projectsAsPhotographyDirector(): HasMany
    {
        return $this->hasMany(Project::class)
            ->wherePivot('role', '=', ProjectUserRole::PhotographyDirector);
    }

    /**
     * @return HasMany<Project>
     */
    public function projectsAsSoundDirector(): HasMany
    {
        return $this->hasMany(Project::class)
            ->wherePivot('role', '=', ProjectUserRole::SoundDirector);
    }

    /**
     * @return HasMany<Project>
     */
    public function projectsAsArtDirector(): HasMany
    {
        return $this->hasMany(Project::class)
            ->wherePivot('role', '=', ProjectUserRole::ArtDirector);
    }
}

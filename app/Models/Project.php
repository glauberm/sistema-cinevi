<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProjectUserRole;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int                 $id
 * @property string              $title
 * @property string              $synopsis
 * @property string              $genres
 * @property ?string             $capture_format
 * @property ?string             $capture_notes
 * @property ?string             $venues
 * @property CarbonImmutable     $pre_production_date
 * @property CarbonImmutable     $production_date
 * @property CarbonImmutable     $post_production_date
 * @property bool                $has_attended_photography_discipline
 * @property bool                $has_attended_sound_discipline
 * @property bool                $has_attended_art_discipline
 * @property User                $owner
 * @property ProductionCategory  $productionCategory
 * @property User                $professor
 * @property Collection<User>    $directors
 * @property Collection<User>    $producers
 * @property Collection<User>    $photographyDirectors
 * @property Collection<User>    $soundDirectors
 * @property Collection<User>    $artDirectors
 * @property FinalCopy           $finalCopy
 */
class Project extends Model
{
    use HasFactory;

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
        'title',
        'synopsis',
        'genres',
        'capture_format',
        'capture_notes',
        'venues',
        'pre_production_date',
        'production_date',
        'post_production_date',
        'has_attended_photography_discipline',
        'has_attended_sound_discipline',
        'has_attended_art_discipline',
        'owner_id',
        'production_category_id',
        'professor_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'pre_production_date' => 'immutable_date',
        'production_date' => 'immutable_date',
        'post_production_date' => 'immutable_date',
        'has_attended_photography_discipline' => 'boolean',
        'has_attended_sound_discipline' => 'boolean',
        'has_attended_art_discipline' => 'boolean',
    ];

    /**
     * @return BelongsTo<User,self>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<ProductionCategory,self>
     */
    public function productionCategory(): BelongsTo
    {
        return $this->belongsTo(ProductionCategory::class);
    }

    /**
     * @return BelongsTo<User,self>
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<User>
     */
    public function directors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('role', '=', ProjectUserRole::Director);
    }

    /**
     * @return BelongsToMany<User>
     */
    public function producers(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('role', '=', ProjectUserRole::Producer);
    }

    /**
     * @return BelongsToMany<User>
     */
    public function photographyDirectors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('role', '=', ProjectUserRole::PhotographyDirector);
    }

    /**
     * @return BelongsToMany<User>
     */
    public function soundDirectors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('role', '=', ProjectUserRole::SoundDirector);
    }

    /**
     * @return BelongsToMany<User>
     */
    public function artDirectors(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('role', '=', ProjectUserRole::ArtDirector);
    }

    /**
     * @return HasOne<FinalCopy>
     */
    public function finalCopy(): HasOne
    {
        return $this->hasOne(FinalCopy::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int                         $id
 * @property string                      $title
 * @property string                      $synopsis
 * @property string                      $genres
 * @property ?string                     $capture_format
 * @property ?string                     $capture_notes
 * @property ?string                     $venues
 * @property ?string                     $video_url
 * @property ?string                     $video_password
 * @property ?string                     $chromia
 * @property ?string                     $proportion
 * @property ?string                     $format
 * @property ?string                     $duration
 * @property ?string                     $native_digital_format
 * @property ?string                     $codec
 * @property ?string                     $container
 * @property ?string                     $bitrate
 * @property ?string                     $fps
 * @property ?string                     $sound
 * @property ?string                     $digital_sound_resolution
 * @property ?string                     $digital_matrix_support
 * @property ?string                     $camera
 * @property string[]|null               $editing_software
 * @property ?string                     $sound_capture_equipment
 * @property ?string                     $budget
 * @property string[]|null               $financing_sources
 * @property ?string                     $supporters
 * @property ?string                     $has_dcp
 * @property ?string                     $cast
 * @property ?string                     $participations
 * @property ?string                     $prizes
 * @property bool                        $confirmed
 * @property User                        $owner
 * @property ProductionCategory          $productionCategory
 * @property User                        $professor
 * @property Project                     $project
 * @property Collection<ProductionRole>  $productionRoles
 */
class FinalCopy extends Model
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
        'video_url',
        'video_password',
        'chromia',
        'proportion',
        'format',
        'duration',
        'native_digital_format',
        'codec',
        'container',
        'bitrate',
        'fps',
        'sound',
        'digital_sound_resolution',
        'digital_matrix_support',
        'camera',
        'editing_software',
        'sound_capture_equipment',
        'budget',
        'financing_sources',
        'supporters',
        'has_dcp',
        'cast',
        'participations',
        'prizes',
        'confirmed',
        'owner_id',
        'production_category_id',
        'professor_id',
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
     * @return BelongsTo<Project,self>
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @return BelongsToMany<ProductionRole>
     */
    public function productionRoles(): BelongsToMany
    {
        return $this->belongsToMany(ProductionRole::class)
            ->using(FinalCopyProductionRole::class);
    }
}

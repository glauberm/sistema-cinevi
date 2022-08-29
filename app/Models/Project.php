<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int              $id
 * @property string           $title
 * @property string           $synopsis
 * @property string[]|string  $genres
 * @property string           $capture_format
 * @property string           $capture_notes
 * @property string           $venues
 * @property Carbon           $pre_production_date
 * @property Carbon           $production_date
 * @property Carbon           $post_production_date
 * @property bool             $has_attended_photography_discipline
 * @property bool             $has_attended_sound_discipline
 * @property bool             $has_attended_art_discipline
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
    ];

    /**
     * @return BelongsTo<User, self>
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<ProductionCategory, self>
     */
    public function productionCategory(): BelongsTo
    {
        return $this->belongsTo(ProductionCategory::class);
    }

    /**
     * @return BelongsTo<User, self>
     */
    public function professor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

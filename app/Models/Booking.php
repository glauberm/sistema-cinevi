<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property integer          $id
 * @property CarbonImmutable  $withdrawal_date
 * @property CarbonImmutable  $devolution_date
 */
class Booking extends Model
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
        'withdrawal_date',
        'devolution_date',
        'owner_id',
        'project_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'withdrawal_date' => 'immutable_datetime:Y-m-d',
        'devolution_date' => 'immutable_datetime:Y-m-d',
    ];

    /**
     * @return BelongsTo<User,self>
     */
    public function owner(): BelongsTo
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
     * @return BelongsToMany<Bookable>
     */
    public function bookables(): BelongsToMany
    {
        return $this->belongsToMany(Bookable::class);
    }
}

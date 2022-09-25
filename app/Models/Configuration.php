<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int                                                $id
 * @property bool                                               $bookings_are_closed
 * @property array<array{month:string,day:string,name:string}>  $bookings_forbidden_dates
 * @property string                                             $final_copies_confirmation_message
 */
class Configuration extends Model
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
        'bookings_are_closed',
        'bookings_forbidden_dates',
        'final_copies_confirmation_message',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'bookings_are_closed' => 'boolean',
        'bookings_forbidden_dates' => AsCollection::class,
    ];
}

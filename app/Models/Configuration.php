<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer                                            $id
 * @property bool                                               $bookings_are_closed
 * @property array<array{month:string,day:string,name:string}>  $bookings_forbidden_dates
 * @property string[]                                           $bookings_create_or_update_emails
 * @property string                                             $final_copies_confirmation_message
 * @property string[]                                           $final_copies_create_emails
 * @property string[]                                           $final_copies_confirmed_emails
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
        'bookings_create_or_update_emails',
        'final_copies_confirmation_message',
        'final_copies_create_emails',
        'final_copies_confirmed_emails',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'bookings_are_closed' => 'boolean',
        'bookings_forbidden_dates' => AsCollection::class,
        'bookings_create_or_update_emails' => 'array',
        'final_copies_create_emails' => 'array',
        'final_copies_confirmed_emails' => 'array',
    ];
}

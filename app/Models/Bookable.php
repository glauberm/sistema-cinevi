<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int     $id
 * @property string  $identifier
 * @property string  $name
 * @property string  $inventory_number
 * @property string  $serial_number
 * @property string  $accessories
 * @property string  $notes
 * @property bool    $is_under_maintenance
 * @property bool    $is_return_overdue
 */
class Bookable extends Model
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
        'identifier',
        'name',
        'inventory_number',
        'serial_number',
        'accessories',
        'notes',
        'is_under_maintenance',
        'is_return_overdue',
    ];
}

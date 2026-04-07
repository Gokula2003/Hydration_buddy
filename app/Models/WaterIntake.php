<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class WaterIntake extends Model
{
    protected $table = 'water_intake';
    
    protected $fillable = [
        'user_identifier',
        'glasses_count',
        'intake_date',
    ];

    protected $casts = [
        'intake_date' => 'date',
        'glasses_count' => 'integer',
    ];

    /**
     * Get or create today's water intake record
     */
    public static function getTodayRecord($userIdentifier = 'default_user')
    {
        return static::firstOrCreate(
            [
                'user_identifier' => $userIdentifier,
                'intake_date' => Carbon::today(),
            ],
            [
                'glasses_count' => 0,
            ]
        );
    }

    /**
     * Get yesterday's water intake record
     */
    public static function getYesterdayRecord($userIdentifier = 'default_user')
    {
        return static::where('user_identifier', $userIdentifier)
            ->where('intake_date', Carbon::yesterday())
            ->first();
    }

    /**
     * Add a glass of water to today's record
     */
    public static function addGlass($userIdentifier = 'default_user')
    {
        $record = static::getTodayRecord($userIdentifier);
        $record->increment('glasses_count');
        return $record->fresh();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\WaterIntake;
use Illuminate\Http\Request;

class HydrationController extends Controller
{
    /**
     * Show the loading screen
     */
    public function welcome()
    {
        return view('welcome-loading');
    }

    /**
     * Show the dashboard
     */
    public function dashboard()
    {
        $today = WaterIntake::getTodayRecord();
        $yesterday = WaterIntake::getYesterdayRecord();
        
        return view('dashboard', [
            'today' => $today,
            'yesterday' => $yesterday,
        ]);
    }

    /**
     * Add a glass of water (API endpoint)
     */
    public function addGlass(Request $request)
    {
        $record = WaterIntake::addGlass();
        
        return response()->json([
            'success' => true,
            'glasses_count' => $record->glasses_count,
            'message' => 'Glass added successfully!',
        ]);
    }

    /**
     * Get today's data (API endpoint)
     */
    public function getTodayData()
    {
        $today = WaterIntake::getTodayRecord();
        
        return response()->json([
            'glasses_count' => $today->glasses_count,
            'intake_date' => $today->intake_date->format('Y-m-d'),
        ]);
    }

    /**
     * Get yesterday's data (API endpoint)
     */
    public function getYesterdayData()
    {
        $yesterday = WaterIntake::getYesterdayRecord();
        
        return response()->json([
            'glasses_count' => $yesterday ? $yesterday->glasses_count : 0,
            'intake_date' => $yesterday ? $yesterday->intake_date->format('Y-m-d') : null,
        ]);
    }
}

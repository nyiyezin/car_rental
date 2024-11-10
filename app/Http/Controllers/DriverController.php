<?php

namespace App\Http\Controllers;

use App\Services\DriverService;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    protected $driverService;

    public function __construct(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    public function index(Request $request)
    {
        $filters = collect($request->only(['is_available']))
            ->filter(function ($value) {
                return $value !== null && $value !== '' && $value !== 0;
            })
            ->toArray();

        $drivers = $this->driverService->getAllDrivers($filters);

        return view('driver.index', [
            'drivers' => $drivers,
        ]);
    }
}

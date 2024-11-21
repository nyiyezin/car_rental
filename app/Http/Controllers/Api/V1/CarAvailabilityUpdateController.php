<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CarService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CarAvailabilityUpdateController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }
    public function __invoke(Request $request, int $id)
    {
        try {
            $car = $this->carService->updateAvailabilityStatus($request, $id);
            return response()->json($car);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}

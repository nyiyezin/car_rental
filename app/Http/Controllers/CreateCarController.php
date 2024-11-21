<?php

namespace App\Http\Controllers;

use App\Services\CarService;
use Illuminate\Http\Request;

class CreateCarController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    public function create()
    {
        $filterOptions = $this->carService->getFilterOptions();
        return view('admin.create-car', compact('filterOptions'));
    }

    public function store(Request $request)
    {
        $data = $request->all();
        $this->carService->createCar($data);
        return redirect()->route('adminDashboard')->with('success', 'Car created successfully!');
    }
}

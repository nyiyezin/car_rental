<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CarService;
use Illuminate\Http\Request;

class AdminCarController extends Controller
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

    public function update(Request $request, int $id)
    {
        $data = $request->all();
        $this->carService->updateCar($id, $data);
        return redirect()->route('adminDashboard')->with('success', 'Car updated successfully!');
    }

    public function destroy(int $id)
    {
        $this->carService->removeCar($id);
        return redirect()->route('adminDashboard')->with('success', 'Car deleted successfully!');
    }

    public function editModal($id)
    {
        $car = $this->carService->getCarById($id);

        return response()->json([
            'modalHtml' => view('components.admin.modals.editCarModal', compact('car'))->render(),
        ]);
    }
}

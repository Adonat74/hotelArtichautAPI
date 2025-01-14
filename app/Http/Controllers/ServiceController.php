<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    public function getSingleService(int $id): object {
        $service = Service::findOrFail($id);
        return response()->json([
            'service'=>$service,
        ]);
    }

    public function getAllService(): JsonResponse
    {
        $services = Service::all();
        return response()->json([
            'services'=>$services,
        ]);
    }


    public function addService(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'price_in_cent' => 'bail|required|numeric|min:0',
                'duration_in_day' => 'bail|required|numeric|min:1',
                'is_per_person' => 'bail|required|boolean',
            ]);
            $service = new Service($validatedData);
            $service->save();
            return response()->json($service);
        } catch (ValidationException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function updateService(Request $request, String $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'price_in_cent' => 'bail|required|numeric|min:0',
                'duration_in_day' => 'bail|required|numeric|min:1',
                'is_per_person' => 'bail|required|boolean',
            ]);

            $service = Service::findOrFail($id);
            $service->update($validatedData);
            return response()->json(['updatedService' => $validatedData]);
        } catch (ValidationException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function deleteService(String $id): JsonResponse
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return response()->json(['deletedService' => $service]);
    }
}

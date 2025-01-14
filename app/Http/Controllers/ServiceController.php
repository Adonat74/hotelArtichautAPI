<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ServiceController extends Controller
{
    public function getSingleService(int $id): object {
        $service = Service::with('images')->findOrFail($id);
        return response()->json([
            'service'=>$service,
        ]);
    }

    public function getAllService(): JsonResponse
    {
        $services = Service::with('images')->get();
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
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $service = new Service([
                'title' => $validatedData['title'],
                'price_in_cent' => $validatedData['price_in_cent'],
                'duration_in_day' => $validatedData['duration_in_day'],
                'is_per_person' => $validatedData['is_per_person'],
            ]);
            $service->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    $imagePath = $image->store('images', 'public');

                    new Image([
                        'url' => $imagePath,
                        'service_id' => $service->primaryKey,
                    ]);
                }
            }


            return response()->json([
                'addedService' => $service->load('images'),
            ]);
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
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
            $service = Service::findOrFail($id);
            $service->update([
                'title' => $validatedData['title'],
                'price_in_cent' => $validatedData['price_in_cent'],
                'duration_in_day' => $validatedData['duration_in_day'],
                'is_per_person' => $validatedData['is_per_person'],
            ]);

            if ($request->hasFile('images')) {
                $existingImages = $service->photos()->all();
                if ($existingImages) {
                    foreach ($existingImages as $existingImage) {

                        Storage::disk('public')->delete($existingImage->url);
                        $existingImage->delete(); // Remove the old image from the database
                    }
                }
                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    new Image([
                        'url' => $imagePath,
                        'service_id' => $service->primaryKey,
                    ]);
                }
            }

            return response()->json(['updatedService' => $validatedData]);
        } catch (ValidationException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function deleteService(String $id): JsonResponse
    {
        $service = Service::findOrFail($id);
        $existingImages = $service->photos()->all();
        if ($existingImages) {
            foreach ($existingImages as $existingImage) {
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->delete(); // Remove the old image from the database
            }
        }
        $service->delete();


        return response()->json(['deletedService' => $service]);
    }
}

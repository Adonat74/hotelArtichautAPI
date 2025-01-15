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
        // le with permet d'afficher les images liées au service sous forme de tableau
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
                'is_per_person' => 'bail|nullable|string|max:5',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);

            // n'enregistre que les fields de service
            $service = new Service([
                'title' => $validatedData['title'],
                'price_in_cent' => $validatedData['price_in_cent'],
                'duration_in_day' => $validatedData['duration_in_day'],
                'is_per_person' => $validatedData['is_per_person'],
            ]);
            $service->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    //enregistre les images dans le dossier storage/app/public/images et l'url pour y accéder dans la table image
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => $imagePath,
                        'service_id' => $service->id,
                    ]);
                    $image->save();
                }
            }
            return response()->json([
                'addedService' => $service->load('images'),
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors());
        }
    }

    public function updateService(Request $request, String $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'price_in_cent' => 'bail|required|numeric|min:0',
                'duration_in_day' => 'bail|required|numeric|min:1',
                'is_per_person' => 'bail|required|string|max:5',
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
                $existingImages = $service->images()->get();

                //supprime les images du strage et l'url de la table images
                if ($existingImages) {
                    foreach ($existingImages as $existingImage) {
                        Storage::disk('public')->delete($existingImage->url);
                        $existingImage->delete();
                    }
                }

                foreach ($request->file('images') as $image) {
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => $imagePath,
                        'service_id' => $service->id,
                    ]);
                    $image->save();
                }
            }

            return response()->json([
                'updatedService' => $service->load('images'),
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors());
        }
    }

    public function deleteService(String $id): JsonResponse
    {
        $service = Service::findOrFail($id);
        $existingImages = $service->images()->get();
        if ($existingImages) {
            foreach ($existingImages as $existingImage) {
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->delete();
            }
        }
        $service->delete();
        return response()->json(['deletedService' => $service->load('images')]);
    }
}

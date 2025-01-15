<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Image;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{

    public function getSingleContent(int $id): object {
        $content = Content::with('images')->findOrFail($id);
        return response()->json([
            'content'=>$content,
        ]);
    }

    public function getAllContent(): JsonResponse
    {
        $contents = Content::with('images')->get();
        return response()->json([
            'contents'=>$contents,
        ]);
    }


    public function addContent(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:100',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'landing_page_display' => 'bail|required|string',
                'navbar_display' => 'bail|required|string',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);
            $content = new Content([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'landing_page_display' => $validatedData['landing_page_display'],
                'navbar_display' => $validatedData['navbar_display'],
            ]);
            $content->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    //enregistre les images dans le dossier storage/app/public/images et l'url pour y accéder dans la table image
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => $imagePath,
                        'content_id' => $content->id,
                    ]);
                    $image->save();
                }
            }
            return response()->json([
                'addedContent' => $content->load('images'),
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors());
        }
    }

    public function updateContent(Request $request, String $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:100',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'landing_page_display' => 'bail|required|string',
                'navbar_display' => 'bail|required|string',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);
            $content = Content::findOrFail($id);
            $content->update([
                'name' => $validatedData['name'],
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
                'landing_page_display' => $validatedData['landing_page_display'],
                'navbar_display' => $validatedData['navbar_display'],
            ]);

            if ($request->hasFile('images')) {
                $existingImages = $content->images()->get();

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
                        'content_id' => $content->id,
                    ]);
                    $image->save();
                }
            }

            return response()->json([
                'addedContent' => $content->load('images'),
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors());
        }
    }

    public function deleteContent(String $id): JsonResponse
    {
        $content = Content::findOrFail($id);
        $existingImages = $content->images()->get();
        if ($existingImages) {
            foreach ($existingImages as $existingImage) {
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->delete();
            }
        }
        $content->delete();

        return response()->json(['deletedContent' => $content->load('images')]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\NewsArticle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class NewsArticleController extends Controller
{
    public function getSingleNewsArticle(int $id): object {

        $newsArticle = NewsArticle::with('images')->findOrFail($id);
        return response()->json([
            'newsArticle'=>$newsArticle,
        ]);
    }

    public function getAllNewsArticle(): JsonResponse
    {
        $newsArticles = NewsArticle::with('images')->get();
        return response()->json([
            'newsArticles'=>$newsArticles,
        ]);
    }


    public function addNewsArticle(Request $request): JsonResponse
    {
        try {

            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);
            $newsArticle = new NewsArticle([
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
            ]);
            $newsArticle->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {

                    //enregistre les images dans le dossier storage/app/public/images et l'url pour y accéder dans la table image
                    $imagePath = $image->store('images', 'public');
                    $image = new Image([
                        'url' => $imagePath,
                        'news_article_id' => $newsArticle->id,
                    ]);
                    $image->save();
                }
            }


            return response()->json([
                'addedNews' => $newsArticle->load('images'),
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors());
        }
    }

    public function updateNewsArticle(Request $request, String $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'images' => 'nullable|array',// vérifie que c'est un tableau
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',// vérifie que les éléments sont des images
            ]);
            $newsArticle = NewsArticle::findOrFail($id);
            $newsArticle->update([
                'title' => $validatedData['title'],
                'short_description' => $validatedData['short_description'],
                'description' => $validatedData['description'],
            ]);


            if ($request->hasFile('images')) {
                $existingImages = $newsArticle->images()->get();

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
                        'news_article_id' => $newsArticle->id,
                    ]);
                    $image->save();
                }
            }

            return response()->json([
                'addedNews' => $newsArticle->load('images'),
            ]);
        } catch (ValidationException $exception) {
            return response()->json($exception->errors());
        }
    }

    public function deleteNewsArticle(String $id): JsonResponse
    {
        $newsArticle = NewsArticle::findOrFail($id);
        $existingImages = $newsArticle->images()->get();
        if ($existingImages) {
            foreach ($existingImages as $existingImage) {
                Storage::disk('public')->delete($existingImage->url);
                $existingImage->delete();
            }
        }
        $newsArticle->delete();
        return response()->json(['deletedNewsArticle' => $newsArticle->load('images')]);
    }
}

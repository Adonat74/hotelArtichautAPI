<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class NewsArticleController extends Controller
{
    public function getSingleNewsArticle(int $id): object {
        $newsArticle = NewsArticle::findOrFail($id);
        return response()->json([
            'newsArticle'=>$newsArticle,
        ]);
    }

    public function getAllNewsArticle(): JsonResponse
    {
        $newsArticles = NewsArticle::all();
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
            ]);
            $newsArticle = new NewsArticle($validatedData);
            $newsArticle->save();
            return response()->json($newsArticle);
        } catch (ValidationException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function updateNewsArticle(Request $request, String $id): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
            ]);

            $newsArticle = NewsArticle::findOrFail($id);
            $newsArticle->update($validatedData);
            return response()->json(['updatedNewsArticle' => $validatedData]);
        } catch (ValidationException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function deleteNewsArticle(String $id): JsonResponse
    {
        $newsArticle = NewsArticle::findOrFail($id);
        $newsArticle->delete();

        return response()->json(['deletedNewsArticle' => $newsArticle]);
    }
}

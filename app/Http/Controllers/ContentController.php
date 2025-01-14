<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ContentController extends Controller
{

    public function getSingleContent(int $id): object {
        $content = Content::findOrFail($id);
        return response()->json([
            'content'=>$content,
        ]);
    }

    public function getAllContent(): JsonResponse
    {
        $contents = Content::all();
        return response()->json([
            'contents'=>$contents,
        ]);
    }


    public function addContent(Request $request) {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:100',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'landing_page_display' => 'bail|required|boolean',
                'navbar_display' => 'bail|required|boolean',
            ]);
            $content = new Content($validatedData);
            $content->save();
            return response()->json($content);
        } catch (ValidationException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function updateContent(Request $request, String $id) {
        try {
            $validatedData = $request->validate([
                'name' => 'bail|required|string|max:100',
                'title' => 'bail|required|string|max:50',
                'short_description' => 'bail|required|string|max:200',
                'description' => 'bail|required|string|max:1000',
                'landing_page_display' => 'bail|required|boolean',
                'navbar_display' => 'bail|required|boolean',
            ]);

            $content = Content::findOrFail($id);
            $content->update($validatedData);
            return response()->json(['updatedContent' => $validatedData]);
        } catch (ValidationException $exception) {
            return response()->json($exception->getMessage());
        }
    }

    public function deleteContent(String $id) {
        $content = Content::findOrFail($id);
        $content->delete();

        return response()->json(['deletedContent' => $content]);
    }
}

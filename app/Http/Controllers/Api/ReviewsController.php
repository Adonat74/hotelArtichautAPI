<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class ReviewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Reviews::all();
        return response()->json([$reviews]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'rate' => 'bail|required|integer',
                'review_content' => 'bail|required|string',
                'user_id' => 'bail|required|integer',
            ]);


            $review = new Reviews($validatedData);
            $review->save();

            return response()->json($review, 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
                'errors' => $exception->errors(),
                ], 422);
        } catch (\Exception $exception) {
            return response()->json([
                'error' => 'Une erreur inattendue est survenue.',
                'details'=>    $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $reviews = Reviews :: findOrFail($id);

        if (!$reviews) {
            return response()->json(['error' => 'review non trouvée'], 404);
        }
        return response()->json([$reviews]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $validatedData = $request->validate([
                'rate' => 'bail|required|integer',
                'review_content' => 'bail|required|string',
                'user_id' => 'bail|required|integer',
            ]);
            $reviews = Reviews :: findOrFail($id);

            if (!$reviews) {
                return response()->json(['error' => 'review non trouvée'], 404);
            }
            $reviews->update($validatedData);

            return response()->json($reviews, 201);
        } catch (ValidationException $exception){
            return response()->json([
                'error' => $exception->getMessage(),
                'errors' => $exception->errors(),
            ], 422);
        } catch (\Exception $exception){
            return response()->json([
                'error' => 'Une erreur inattendue est survenue.',
                'details'=>    $exception->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reviews = Reviews ::findOrFail($id);
        if (!$reviews) {
            return response()->json(['error' => 'review non trouvée']);
        }
        $reviews->delete();

        return response()->json(['message' => 'review supprimée avec succès']);
    }
}

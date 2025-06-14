<?php

namespace App\Services;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ErrorsService
{
    public function exception(string $data, Exception $e) {
        return response()->json([
            'error' => 'An error occurred during the ' . $data . ' operation',
            'message' => $e->getMessage(),
        ], 500);
    }

    public function modelNotFoundException(string $data, ModelNotFoundException $e) {
        return response()->json([
            'error' => $data . ' not found',
            'message' => $e->getMessage(),
        ], 404);
    }


    public function validationException(string $data, ValidationException $e) {
        return response()->json([
            'error' => $data . ' validation failed',
            'message' => $e->errors(),
        ], 422);
    }
}
